import {makeReducer} from '#/main/core/utilities/redux'
import {update} from './../utils'

import {
  IN_SEARCH_ARTICLE,
} from './../actions/search'


function searchArticle (state, action) {
	//console.log('event_search_action_state', action, state)
	let newState    = state
	let searchValue = action.value
	newState = update(newState, {value: {$set: searchValue}})
	return newState
}



const searchReducer = makeReducer([], {
  [IN_SEARCH_ARTICLE]: searchArticle,
})


export default searchReducer