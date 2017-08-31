import {makeActionCreator} from '#/main/core/utilities/redux'
import {REQUEST_SEND}      from './actionsApi'

export const CANCEL_ADD_ARTICLE = 'CANCEL_ADD_ARTICLE'
export const SAVE_NEW_ARTICLE   = 'SAVE_NEW_ARTICLE'
export const OPEN_MODAL         = 'OPEN_MODAL'
export const CLOSE_MODAL        = 'CLOSE_MODAL'


export const actions  = {}

actions.cancelAddArticle = makeActionCreator(CANCEL_ADD_ARTICLE, 'open')
actions.saveNewArticle   = makeActionCreator(SAVE_NEW_ARTICLE, 'type')
actions.openModal        = makeActionCreator(OPEN_MODAL, 'open')
actions.closeModal       = makeActionCreator(CLOSE_MODAL, 'open')

actions.saveArticle = (type) => ({
  [REQUEST_SEND]: {
    route: ['save_entry'],
    request: {
      method: 'PUT',
      body: JSON.stringify({type})
    },
    success: () => actions.saveNewArticle(type)
  }
})


console.log(actions)