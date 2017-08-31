import {makeReducer} from '#/main/core/utilities/redux'
import {update} from './../utils'

import {
  CANCEL_ADD_ARTICLE,
  SAVE_NEW_ARTICLE,
  OPEN_MODAL,
  CLOSE_MODAL
} from './../actions/modal'


function openModal(state, action) {
	let newState   = state
	newState = update(newState, {open: {$set: true}})
	return newState
}


function closeModal (state, action) {
	let newState   = state
	newState = update(newState, {open: {$set: false}})
	return newState
}

function cancelAddArticle(state, action) {
	let newState   = state
	return newState
}


function saveNewArticle (state, action) {
	let newState   = state
	return newState
}


const modalReducer = makeReducer([], {
  [CANCEL_ADD_ARTICLE]: cancelAddArticle,
  [SAVE_NEW_ARTICLE]: saveNewArticle,
  [OPEN_MODAL]: openModal,
  [CLOSE_MODAL]: closeModal
})


export default modalReducer