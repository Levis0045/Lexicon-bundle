import {makeActionCreator} from '#/main/core/utilities/redux'

import {REQUEST_SEND} from './actionsApi'

export const IN_SEARCH_ARTICLE  = 'IN_SEARCH_ARTICLE'


export const actions = {}

actions.searchArticle  = makeActionCreator(IN_SEARCH_ARTICLE, 'value')


console.log(actions)