import {makeActionCreator} from '#/main/core/utilities/redux'
import axios from 'axios'

import {REQUEST_SEND} from './actionsApi'

export const DELETE_ARTICLE     = 'DELETE_ARTICLE'
export const SHARE_ARTICLE      = 'SHARE_ARTICLE'
export const CONSULT_ARTICLE    = 'CONSULT_ARTICLE'
export const ADD_NEW_ARTICLE    = 'ADD_NEW_ARTICLE'
export const ARTICLES_SET       = 'ARTICLES_SET'

export const actions = {}

actions.setArticles       = makeActionCreator(ARTICLES_SET, 'articles')
actions.deleteArticle     = makeActionCreator(DELETE_ARTICLE, 'handle')
actions.shareArticle      = makeActionCreator(SHARE_ARTICLE, 'handle')
actions.consultArticle    = makeActionCreator(CONSULT_ARTICLE, 'entry', 'content')
actions.addNewArticle     = makeActionCreator(ADD_NEW_ARTICLE, 'articles')

/*
actions.viewArticle = (handle, currentContentArticle) => ({
  [REQUEST_SEND]: {
    route: ['consult_article'],
    request: {
      method: 'GET',
      body: JSON.stringify({old, newT})
    },
    success: () => actions.consultArticle(handle, currentContentArticle)
  }
}) */


console.log(actions)