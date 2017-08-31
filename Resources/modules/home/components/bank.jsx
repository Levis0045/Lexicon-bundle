import React from 'react'
import {PropTypes as T} from 'prop-types'
import {connect} from 'react-redux'
import classes from 'classnames'

import {tex, transChoice, trans, translex} from '#/main/core/translation'
import {makeModal} from '#/main/core/layout/modal'
import {actions as modalActions} from '#/main/core/layout/modal/actions'
import { Page, PageHeader, PageContent} from '#/main/core/layout/page/components/page.jsx'
import { PageActions, PageAction } from '#/main/core/layout/page/components/page-actions.jsx'
import { Pagination } from '#/main/core/layout/pagination/components/pagination.jsx'

import {select} from './../selectors'
import {actions as paginationActions} from './../actions/pagination'
import {actions as searchActions} from './../actions/search'
import {actions as createLexiconAction} from './../actions/createLexicon'
import {select as paginationSelect} from './../selectors/pagination'
import {getVisibleQuestions} from './../selectors/questions'

import VisibleQuestions from './../containers/visible-questions.jsx'

import {MODAL_SEARCH} from './modal/search.jsx'
import {MODAL_CREATE_LEXICON} from './modal/create-lexicon.jsx'

// TODO : do not load add item modal from editor
// TODO : finish to refactor modals for using the ones embed in <Page> component

const Bank = props =>
  <Page
    modal={props.modal}
    fadeModal={props.fadeModal}
    hideModal={props.hideModal}
  >
    <PageHeader
      title={translex('claroline_lexicon')}
    >
      <PageActions>
        <PageAction
          id="lexicon-create"
          title={transChoice('Créer une nouvelle ressource lexicale ?', props.activeFilters, {count: props.activeFilters}, 'lexicon')}
          icon="fa fa-plus"
          action={() => props.openCreateLexiconModal(props.questions)}
        >
           
        </PageAction>
        <span className="text-muted" style={{fontSize:30}}><span className="text-muted" style={{width:140, margin:10}}></span></span>
        <PageAction
          id="bank-search"
          title={transChoice('active_filters', props.activeFilters, {count: props.activeFilters}, 'lexicon')}
          icon="fa fa-search"
          action={() => props.openSearchModal(props.searchFilters)}
        >
            <span className={classes('label', 0 < props.activeFilters ? 'label-primary' : 'label-default')}>
              {props.activeFilters}
            </span>
        </PageAction>
      </PageActions>
    </PageHeader>

    {props.modal.type &&
      props.createModal(
        props.modal.type,
        props.modal.props,
        props.modal.fading
      )
    }

    <PageContent>
      {0 === props.totalResults &&
        <div className="panel panel-body">
          <div className="empty-list">
            &nbsp;&nbsp;Ousp ! No results found <small className="fa fa-frown-o" style={{fontSize:20}}></small><br/><br/>&nbsp;&nbsp;
            Vous n'avez pas encore crée de ressource(s) lexicale(s) ou aucune(s) ressource(s) lexicale(s) n'a été partagée avec vous &#9785; &#9785; !
          </div>
        </div>
      }

      {0 < props.totalResults &&
        <VisibleQuestions />
      }

      {0 < props.totalResults &&
      <Pagination
        current={props.pagination.current}
        pageSize={props.pagination.pageSize}
        pages={props.pages}
        handlePageChange={props.handlePageChange}
        handlePagePrevious={props.handlePagePrevious}
        handlePageNext={props.handlePageNext}
        handlePageSizeUpdate={props.handlePageSizeUpdate}
      />
      }
    </PageContent>
  </Page>

Bank.propTypes = {
  totalResults: T.number,
  searchFilters: T.object.isRequired,
  questions: T.array.isRequired,
  activeFilters: T.number.isRequired,
  modal: T.shape({
    type: T.string,
    fading: T.bool.isRequired,
    props: T.object.isRequired
  }),
  pages: T.number.isRequired,
  pagination: T.shape({
    current: T.number.isRequired,
    pageSize: T.number
  }),
  createModal: T.func.isRequired,
  fadeModal: T.func.isRequired,
  hideModal: T.func.isRequired,
  openSearchModal: T.func.isRequired,
  openCreateLexiconModal: T.func.isRequired,
  handlePageChange: T.func.isRequired,
  handlePagePrevious: T.func.isRequired,
  handlePageNext: T.func.isRequired,
  handlePageSizeUpdate: T.func.isRequired
}

function mapStateToProps(state) {
  return {
    searchFilters: select.filters(state),
    activeFilters: select.countFilters(state),
    modal: select.modal(state),
    questions: getVisibleQuestions(state),
    totalResults: paginationSelect.getTotalResults(state),
    pagination: paginationSelect.getPagination(state),
    pages: paginationSelect.countPages(state)
  }
}

function mapDispatchToProps(dispatch) {
  return {
    createModal: (type, props, fading) => makeModal(type, props, fading, dispatch),
    fadeModal() {
      dispatch(modalActions.fadeModal())
    },
    hideModal() {
      dispatch(modalActions.hideModal())
    },
    openSearchModal(searchFilters) {
      dispatch(modalActions.showModal(MODAL_SEARCH, {
        title: translex('search'),
        filters: searchFilters,
        handleSearch: (searchFilters) => dispatch(searchActions.search(searchFilters)),
        clearFilters: () => dispatch(searchActions.clearFilters()),
        fadeModal: () => dispatch(modalActions.fadeModal())
      }))
    },
    openCreateLexiconModal(questions) {
      dispatch(modalActions.showModal(MODAL_CREATE_LEXICON, {
        title: translex('Créer une nouvelle ressource lexicale'),
        handleCreateLexicon: (questions) => dispatch(createLexiconAction.createLexicon(questions)),
        dataSave : () => dispatch(createLexiconAction.saveResource()),
        fadeModal: () => dispatch(modalActions.fadeModal())
      }))
    },
    handlePagePrevious() {
      dispatch(paginationActions.previousPage())
    },
    handlePageNext() {
      dispatch(paginationActions.nextPage())
    },
    handlePageChange(page) {
      dispatch(paginationActions.changePage(page))
    },
    handlePageSizeUpdate(pageSize) {
      dispatch(paginationActions.updatePageSize(pageSize))
    }
  }
}

const ConnectedBank = connect(mapStateToProps, mapDispatchToProps)(Bank)


export {ConnectedBank as Bank}
