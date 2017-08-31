import {makeReducer} from '#/main/core/utilities/redux'
import {update} from './../utils'

import {
	CLICK_EDIT_TITLE, 
	SAVE_EDIT_TITLE,
	SAVE_EDIT_ARTICLE
} from './../actions/metaResource'

import {CLICK_EDIT_ARTICLE, CLICK_SEARCH_ARTICLE} from './../actions/clicks'
import {TOTAL_ARTICLES_CHANGE} from './../actions/totalArticles'



function clickEditTitle (state, action) {
	console.log(action)
	let newState   = state
	newState = update(newState, {editable: {$set: true}})
	console.log('newState_click', newState)
	return newState
}

function saveEditArticle (state, action) {
	let newState = state
	//let content = action.currentContentArticle
	newState = update(newState, {articleEditable: {$set: false}})
	/*newState = update(updateEditable(newState), 
		{
		 $set: <div dangerouslySetInnerHTML={{__html: content}}/>
		}
	)*/
  	return newState
}

function saveEditTitle (state, action) {
	const newTitle = action.newT
	let newState   = state
	newState = update(newState, {
		editable: {$set: false},
		title: {$set: newTitle}
	})
	return newState
}

function clickEditArticles(state, action) {
    let newState = state
    console.log('clickEditArticles',newState, action)
	newState = update(newState, {articleEditable: {$set: true}})
	return newState
}

function clickSearchArticles(state, action) {
	let newState = state
	console.log('clickSearchArticles', newState, action)
	newState = update(newState, {searchable: {$set: true}})
	return newState
}

function changeTotalArticles (state, action) {
	console.log(action)
	let newState   = state
	newState = update(newState, {clickeditTitle: {$set: true}})
	return newState
}



const metaResourceReducer = makeReducer([], {
  [CLICK_EDIT_TITLE]: clickEditTitle,
  [SAVE_EDIT_TITLE]: saveEditTitle,
  [CLICK_EDIT_ARTICLE]: clickEditArticles,
  [CLICK_SEARCH_ARTICLE]: clickSearchArticles,
  [TOTAL_ARTICLES_CHANGE]: changeTotalArticles,
  [SAVE_EDIT_ARTICLE]: saveEditArticle
})


export default metaResourceReducer