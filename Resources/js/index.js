// @flow
import {listItemActionRegistry} from 'sulu-admin-bundle/views';
import {viewRegistry} from 'sulu-admin-bundle/containers';
import DynamicPreview from './views/DynamicPreview';
import DynamicPreviewItemAction from './listItemActions/DynamicPreviewItemAction';

listItemActionRegistry.add('sulu_form.dynamic_preview_item_action', DynamicPreviewItemAction);
viewRegistry.add('sulu_form.dynamic_preview', DynamicPreview);
