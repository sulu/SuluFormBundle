// @flow
import {AbstractListItemAction} from 'sulu-admin-bundle/views';

export default class DynamicPreviewItemAction extends AbstractListItemAction {
  getItemActionConfig(item: ?Object) {
    return {
      icon: 'su-eye',
      disabled: false,
      onClick: item ? () => this.handleClick(item) : undefined,
    };
  }

  handleClick = (item) => {
    this.router.navigate(
      'sulu_form.edit_form.data_details',
      {
        formId: this.listStore.metadataOptions.id,
        id: item.id
      }
    )
  };
}
