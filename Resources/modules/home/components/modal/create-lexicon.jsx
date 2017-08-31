import React, {Component} from 'react'
import {PropTypes as T} from 'prop-types'
import Modal from 'react-bootstrap/lib/Modal'

import {update} from './../../utils/utils'
import {t, tex} from '#/main/core/translation'
import {FormGroup} from '#/main/core/layout/form/components/form-group.jsx'
import {BaseModal} from '#/main/core/layout/modal/components/base.jsx'
import {UserTypeahead} from './../../users/components/typeahead.jsx'

export const MODAL_CREATE_LEXICON = 'MODAL_CREATE_LEXICON'


export class CreateLexiconModal extends Component {
  constructor(props) {
    super(props)

    this.state = {
      adminRights: false,
      questions: Object.assign({
        type : '',
        category : '',
        name : '',
        fullname : ''
      }, props.data)
    }
  }

  updateData(name, value) {
    this.setState(update(this.state, {questions: {[name]: {$set: value}}}))
  }


  render() {
    return (
        <BaseModal {...this.props} className="create-lexicon-modal">
        <Modal.Body>
          <FormGroup
            controlId="type-resource"
            label={'type'}
          >
            <input
              id="type-resource"
              type="text"
              placeholder="Votre ressource est-elle monodirectionnel ou  bidirectionnel ?"
              className="form-control "
              value={this.state.questions.type}
              onChange={e => this.updateData('type', e.target.value)}
            />
          </FormGroup>
          <FormGroup
            controlId="decription-resource"
            label={'Catégorie de la ressource'}
          >
             <input
              id="category-resource"
              type="text"
              placeholder="Votre ressource est-elle bilingue ou monolingue ?"
              className="form-control"
              value={this.state.questions.category}
              onChange={e => this.updateData('category', e.target.value)}
            />
          </FormGroup>
          <FormGroup
            controlId="title-resource"
            label={tex('Nom minimal de la ressource')}
          >
            <input
              id="name-resource"
              type="text"
              placeholder="Quel nom minimal donnez vous à votre ressource ?"
              className="form-control"
              value={this.state.questions.name}
              onChange={e => this.updateData('name', e.target.value)}
            />
          </FormGroup>
          <FormGroup
            controlId="decription-resource"
            label={'Nom complet de la ressource'}
          >
             <input
              id="fullname-resource"
              type="text"
              placeholder="Quel nom complet donnez vous à votre ressource ?"
              className="form-control"
              value={this.state.questions.fullname}
              onChange={e => this.updateData('fullname', e.target.value)}
            />
          </FormGroup>
        </Modal.Body>

        <Modal.Footer>
          <button className="btn btn-default" onClick={this.props.fadeModal}>
            {t('cancel')}
          </button>
          <button className="btn btn-primary" onClick={() => this.props.handleCreateLexicon(this.state.questions)}>
            {t('Créer')}
          </button>
        </Modal.Footer>
      </BaseModal>
    )
  }
}

CreateLexiconModal.propTypes = {
  questions: T.shape({
    type: T.string.isRequired,
    category: T.string.isRequired,
    name: T.string.isRequired,
    fullname: T.string.isRequired
  }).isRequired,
  fadeModal: T.func.isRequired,
  handleCreateLexicon: T.func.isRequired
}
  
