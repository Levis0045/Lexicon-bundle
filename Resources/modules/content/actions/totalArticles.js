import {makeActionCreator} from '#/main/core/utilities/redux'

export const TOTAL_ARTICLES_CHANGE = 'TOTAL_ARTICLES_CHANGE'

export const actions = {}

actions.changeTotalArticles = makeActionCreator(TOTAL_ARTICLES_CHANGE, 'totalArticles')
