import {createSelector} from 'reselect'
import {size} from 'lodash/size'


const getArticles       = (state) => state.articles
const getTotalArticles  = (state) => state.totalArticles
const getCurrentContentArticle = (state) => state.currentContentArticle

const getSearchArticle  = createSelector(
  [getArticles],
  (articles) => size(articles)
)



export const select = {     
	getArticles, 
	getSearchArticle,
	getTotalArticles,
	getCurrentContentArticle
}
       


console.log(select)