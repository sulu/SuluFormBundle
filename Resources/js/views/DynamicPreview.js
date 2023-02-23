// @flow
import React from 'react';
import {observer} from 'mobx-react';
import {action, observable} from 'mobx';
import {Loader} from 'sulu-admin-bundle/components';
import Snackbar from 'sulu-admin-bundle/components/Snackbar';
import {withToolbar} from 'sulu-admin-bundle/containers';
import {ResourceRequester} from 'sulu-admin-bundle/services';

@observer
class DynamicPreview extends React.Component {
  @observable loading = false;
  @observable data = undefined;

  componentDidMount() {
    this.loadData();
  }

  @action loadData = () => {
    this.loading = true;
    this.data = undefined;

    const dataResourceKey = this.props.router.route.options.dataResourceKey;

    return ResourceRequester.get(dataResourceKey, {id: this.getDataId()})
      .then(action(response => {
        console.log('RESPONSE', response);
        this.data = response;
      }))
      .catch(e => {
        console.error('Error while loading dynamic form data from server.', e);
      })
      .finally(action(() => {
        this.loading = false;
      }));
  }

  @action navigateToFormData = () => {
    const routeAttributes = this.props.router.attributes;
    this.props.router.navigate(
      this.props.router.route.options.dataListView,
      {
        locale: routeAttributes.locale,
        id: routeAttributes.formId,
      }
    )
  }

  getDataId() {
    return this.props.router.attributes.id;
  }

  render() {
    if (this.loading) {
      return <Loader/>;
    }

    if (!this.data) {
      return <Snackbar message="No data found!" type="error"/>
    }

    return (
      <div>
        <h1>Form submission from {this.data.typeName}</h1>
        <small>Submitted at: {this.data.created}</small>
        <dl>
        {Object.keys(this.data.data).map((key, index) => (
          <React.Fragment key={index}>
            <dt>{key}</dt>
            <dd>{this.data.data[key]}</dd>
          </React.Fragment>
        ))}
        </dl>
      </div>
    );
  }
}

export default withToolbar(DynamicPreview, function () {
  return {
    items: [
      {
        type: 'button',
        icon: 'su-angle-left',
        disabled: false,
        onClick: () => {
          this.navigateToFormData();
        },
      }
    ]
  };
});
