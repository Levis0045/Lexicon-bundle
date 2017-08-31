import React from 'react'

import {makeReducer} from '#/main/core/utilities/redux'
import {update} from './../utils'
import axios from 'axios'

import {
  CONSULT_ARTICLE
} from './../actions/articles'


function updateEditable(newState) {
	newState = update(newState, {articleEditable: {$set: false}})
  	return newState
}



function consultArticle(state, action) {
	//console.log(action)
	let newState    = state
	const entry     = action.entry
	let content     = action.content
	
	newState = update(updateEditable(newState), 
		{
		 $set: <div dangerouslySetInnerHTML={{__html: content}}/>
		}
	)
    return newState
}



const currentArticlesReducer = makeReducer([], {
  [CONSULT_ARTICLE]: consultArticle
})


export default currentArticlesReducer


