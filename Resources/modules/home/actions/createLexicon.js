import {makeActionCreator} from '#/main/core/utilities/redux'

import {REQUEST_SEND} from './../api/actions'
import {actions as modalActions} from '#/main/core/layout/modal/actions'
import {actions as questionActions} from './questions'
import {actions as totalResultsActions} from './total-results'

export const SEARCH_CLEAR_FILTERS  = 'SEARCH_CLEAR_FILTERS'
export const ADD_NEW_RESOURCE      = 'ADD_NEW_RESOURCE'

export const actions = {}

actions.fetchLexicons = (questions, pagination = {}, sortBy = {}) => ({
  [REQUEST_SEND]: {
    route: ['questions_share'],
    request: {
      method: 'POST',
      body: JSON.stringify({
        questions,
        pagination,
        sortBy
      })
    },
    success: (questionsResults, dispatch) => {
      // Update total results
      dispatch(totalResultsActions.changeTotalResults(questionsResults.totalResults))
      // Update questions list
      dispatch(questionActions.setQuestions(questionsResults.questions))
    }
  }
})

actions.addNewResource = makeActionCreator(ADD_NEW_RESOURCE, 'questions')

actions.createLexicon = (questions, pagination = {}, sortBy = {}) => {
  return (dispatch) => {
    // Close search modal
    dispatch(modalActions.fadeModal())

    // Update filters
    dispatch(actions.addNewResource(questions))

    // Fetch new questions list
    return dispatch(actions.fetchLexicons(questions, pagination, sortBy))
  }
}

actions.saveResource = (pagination = {}, sortBy = {}) => {
  return (dispatch) => {
    // Close search modal
    dispatch(modalActions.fadeModal())

    // Update filters
    dispatch(actions.addNewResource({}))

    // Fetch new questions list
    return dispatch(actions.fetchLexicons({}, pagination, sortBy))
  }
}
