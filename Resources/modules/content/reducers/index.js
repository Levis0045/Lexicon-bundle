import { combineReducers } from 'redux'


import searchReducer           from './search'
import metaResourceReducer     from './metaResource'
import articlesReducer         from './articles'
import modalReducer            from './modal'
import currentArticlesReducer  from './consultArticles'

export const lexiconApp = combineReducers({
  metaResource: metaResourceReducer,
  articles:  articlesReducer,
  modal: modalReducer,
  search: searchReducer,
  currentContentArticle: currentArticlesReducer,
  currentUser: (state = null) => state
})



//console.log(lexiconApp)