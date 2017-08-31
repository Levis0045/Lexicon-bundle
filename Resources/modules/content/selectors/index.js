import {createSelector} from 'reselect'
//import size from 'lodash/size'

const getModal         = state => state.modal
const getCurrentUser   = (state) => state.currentUser
const getSearch        = state => state.search
const getArticleEditable  = state => state.articleEditable

const getSearchCurrentValue = createSelector(
  [getSearch],
  (search) => search.currentValue
)

const getSearchStatus = createSelector(
  [getSearch],
  (search) => search.searchable
)

const getModalStatus = createSelector(
  [getModal],
  (modal) => modal.open
)


export const select = {
  getModal,
  getCurrentUser,
  getSearch,
  getSearchCurrentValue,
  getSearchStatus,
  getModalStatus,
  getArticleEditable
}
