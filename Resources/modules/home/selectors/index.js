import {createSelector} from 'reselect'
import size from 'lodash/size'

const modal = state => state.modal
const filters = state => state.search
const newLexicon = state => state.createLexicon
const selected = state => state.selected
const currentUser = state => state.currentUser
const countFilters = createSelector(
  [filters],
  (filters) => size(filters)
)

export const select = {
  newLexicon,
  modal,
  filters,
  selected,
  currentUser,
  countFilters
}
