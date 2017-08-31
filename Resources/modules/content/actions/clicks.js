import {makeActionCreator} from '#/main/core/utilities/redux'

import {REQUEST_SEND} from './actionsApi'

export const CLICK_EDIT_ARTICLE = 'CLICK_EDIT_ARTICLE'
export const CLICK_SEARCH_ARTICLE  = 'CLICK_SEARCH_ARTICLE'

export const actions = {}


actions.clickEditArticle    = makeActionCreator(CLICK_EDIT_ARTICLE, 'articleEditable')
actions.clickSearchArticle  = makeActionCreator(CLICK_SEARCH_ARTICLE, 'searchable')


console.log(actions)