import {makeActionCreator} from '#/main/core/utilities/redux'
import {REQUEST_SEND} from './actionsApi'

export const CLICK_EDIT_TITLE = 'CLICK_EDIT_TITLE'
export const SAVE_EDIT_TITLE  = 'SAVE_EDIT_TITLE'
export const SAVE_EDIT_ARTICLE  = 'SAVE_EDIT_ARTICLE'

export const actions  = {}

actions.saveEditArticle = makeActionCreator(SAVE_EDIT_ARTICLE, 'editable', 'currentContentArticle')
actions.saveEditTitle   = makeActionCreator(SAVE_EDIT_TITLE, 'old', 'newT')
actions.clickEditTitle  = makeActionCreator(CLICK_EDIT_TITLE, 'editable')

actions.saveTitle = (old, newT) => ({
  [REQUEST_SEND]: {
    route: ['edit_title_resource'],
    request: {
      method: 'PUT',
      body: JSON.stringify({old, newT})
    },
    success: () => actions.saveEditTitle(old, newT)
  }
})


console.log(actions)