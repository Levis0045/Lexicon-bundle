import React from 'react'
import {makeReducer} from '#/main/core/utilities/redux'
import {update} from './../utils'

import {
  ARTICLES_SET,
  DELETE_ARTICLE,
  SHARE_ARTICLE,
  ADD_NEW_ARTICLE
} from './../actions/articles'


function updateEditable(State) {
	let newState = update(State, {articleEditable: {$set: false}})
  	return newState
}

function setArticles(state, action) {
	let newState   = state
	//LoadingIndicator.show()
	newState = update(newState, {$set: action.articles})
	return newState
}

function deleteArticle(state, action) {
	console.log(action)
	let newState   = state
	//newState = update(newState, {clickeditTitle: {$set: true}})
	return newState
}

function shareArticle(state, action) {
	console.log(action)
	let newState   = state
	//newState = update(newState, {clickeditTitle: {$set: true}})
	return newState
}

function addNewArticle(state, action) {
	console.log(action)
	let newState   = state
	//newState = update(newState, {clickeditTitle: {$set: true}})
	return newState
}

const articlesReducer = makeReducer([], {
  [ARTICLES_SET]: setArticles,
  [DELETE_ARTICLE]: deleteArticle,
  [SHARE_ARTICLE]: shareArticle,
  [ADD_NEW_ARTICLE]: addNewArticle
})


export default articlesReducer