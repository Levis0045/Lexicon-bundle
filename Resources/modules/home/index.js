import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import {Provider} from 'react-redux'

import {createStore} from './store'
import {registerModalType} from '#/main/core/layout/modal'
import {MODAL_SEARCH, SearchModal} from './components/modal/search.jsx'
import {MODAL_SHARE, ShareModal} from './components/modal/share.jsx'
import {MODAL_CREATE_LEXICON, CreateLexiconModal} from './components/modal/create-lexicon.jsx'
import {Bank} from './components/bank.jsx'

 
// Load question typeset et toi  et oiok


// Register needed modals
registerModalType(MODAL_SEARCH, SearchModal)
registerModalType(MODAL_SHARE, ShareModal)
registerModalType(MODAL_CREATE_LEXICON, CreateLexiconModal)

// Get initial data
 const listResources = JSON.parse(document.getElementById('lexicon').dataset.resources)
 const currentUser   = JSON.parse(document.getElementById('lexicon').dataset.user)

 //console.log(listResources) et lui 
 const data = []
 data.push(listResources.dico, listResources.dico2);

 const store = createStore(Object.assign({}, listResources, {
    currentUser })
  );


class LexiconComponents extends Component {

  constructor(props) {
    super(props);
  }

  render() {

    return (
      React.createElement(
        Provider,
        {store},
        React.createElement(Bank)
      )
    );
  }
}

ReactDOM.render(
  <LexiconComponents />,
  document.getElementById('lexicon')
)
