import React, { Component } from 'react';
import {PropTypes as T} from 'prop-types'
import {OverlayTrigger, Tooltip} from 'react-bootstrap'
import Modal from 'react-bootstrap/lib/Modal'
import {FormGroup} from '#/main/core/layout/form/components/form-group.jsx'
import {BaseModal} from '#/main/core/layout/modal/components/base.jsx'




{/* Zone de création de nouvelles ressources lexicales */}
const AddEntry = props =>
	<span id="add_entry">
		<div className="modal fade" id="add_new_entry" role="dialog">
		    <div className="modal-dialog">
		      <div className="modal-content">
		        <div className="modal-header">
		          <button type="button" className="close" data-dismiss="modal">&times;</button>
		          <h4 className="modal-title">Ajouter une nouvelle entrée</h4>
		        </div>
		        <div className="modal-body">
		        	<div className="row">
						<div className="form-horizontal">
						    <div className="form-group">
						      <label className="control-label col-sm-3" htmlFor="entry">Entrée </label>
						      <div className="col-sm-8">
						      		<input type="text" className="form-control" id="entry" placeholder="Indiquer l'intitulé du mot traité" name="entry"/>
						      </div>
						    </div>
						    <div className="form-group">
						      <label className="control-label col-sm-3" htmlFor="cat">Catégorie</label>
						      <div className="col-sm-8">          
						        <input type="text" className="form-control" id="cat" placeholder="Indiquer la catégorie grammaticale ?" name="cat"/>
						      </div>
						    </div>
						     <div className="form-group">
						      <label className="control-label col-sm-3" htmlFor="def">Définition</label>
						       <div className="col-sm-8 btn-inline">
									<input type="text" name="def" id="def"  className="form-control"/>
									<button type="button" className="btn btn-primary btn-inline">
									<i className="fa fa-plus"/>
									</button>
							   </div>
						    </div>
						    <div className="form-group">
						      <label className="control-label col-sm-3" htmlFor="expl">Exemple</label>
						       <div className="col-sm-8 btn-inline">
									<input type="text" name="expl" id="expl"  className="form-control"/>
									<button type="button" className="btn btn-primary btn-inline">
									<i className="fa fa-plus"/>
									</button>
							   </div>
						    </div>
						    <div className="form-group">
						     <div className="col-md-10 btn-inline"><hr/>
						     	<a className="col-md-6 btn-inline" href="" title="">
						     	<i className="fa fa-caret-right"/> Plus de champs ? </a>
						     </div>
						    </div>
				        </div>
				    </div>
				</div>
		        <div className="modal-footer">
		          <button type="button" className="btn btn-default" data-dismiss="modal">Annuler</button>
		          <button type="button" className="btn btn-primary">Créer</button>
		        </div>
		      </div>
		    </div>
		</div>
		 <OverlayTrigger trigger={['hover', 'focus']} placement="top" overlay={popoverCreateArticle}>
			<button className="btn page-action-btn" type="button" role="button"
			 	onClick={() => props.modalAddArticle(props.modal.open)} style={{marginBottom:10}}
				data-toggle="modal" data-target="#add_new_entry"
			>
				<i className="page-action-icon fa fa-plus" style={{"fontSize":"14pt"}}/>
			</button>
		</OverlayTrigger>
	</span>

AddEntry.propTypes = {
  modalAddArticle: T.func.isRequired,  //à revoir
  modal: T.shape({
  	type: T.string.isRequired,
  	open: T.bool
  }).isRequired
}

const popoverCreateArticle = (
  <Tooltip id="popover-trigger-hover-focus">
    <span> Cliquez pour ajouter une nouvelle entrée </span>
  </Tooltip>
)

const popoverEditTitleArticle = (
  <Tooltip id="popover-trigger-hover-focus">
    <span> Cliquez pour modifier le titre de la ressource</span>
  </Tooltip>
)

{/* Zone de création de nouvelles ressources lexicales */}
class TitleHeader extends Component {
	constructor(props) {
	    super(props);
	    this.title = {old: this.props.metaResource.title, new:''}
	    this.handleChange = this.handleChange.bind(this)
	}
	handleChange(event) { 
	   this.title.new = event.target.value
	   console.log(event.target.value)
	}
	render() {
		return (
			<span>
				{this.props.metaResource.editable ?
					(<span className="input-group col-xs-4" style={{'display':'inline-block'}}>
					    <input type="text" className="form-control input-lg" 
					    	placeholder="Search" style={{fontSize:20}} onChange={this.handleChange}
							defaultValue={this.props.metaResource.title}  name="title"/>
					    <span className="input-group-btn" style={{marginLeft:-10, 'display':'inline-block'}}>
					      <button className="btn btn-default input-lg" 
					      	type="submit" onClick={() => this.props.actionSaveTitleEdit(this.title.old, this.title.new)} >
					        <i className="fa fa-floppy-o" style={{fontSize:25}}></i>
					      </button>
					    </span>
					</span>
					) : (
					<OverlayTrigger trigger={['hover', 'focus']} placement="right" overlay={popoverEditTitleArticle}>
						<span id="titre-up" style={{'cursor': 'pointer'}} 
							onClick={() => this.props.clickEditTitle(this.props.metaResource.editable)}>
							{this.props.metaResource.title}
						</span>
					</OverlayTrigger>
					)
				}
			</span>
		);
	}
}

TitleHeader.propTypes = {
  metaResource: T.shape({
    id: T.string.isRequired,
    type: T.string.isRequired,
    lang: T.string.isRequired,
    title: T.string.isRequired,
    author: T.string.isRequired,
    editable: T.bool,
    searchable: T.bool,
	articleEditable: T.bool
  }).isRequired,
  actionSaveTitleEdit: T.func.isRequired,
  clickEditTitle: T.func.isRequired //a revoir
}


{/* Zone de création de nouvelles ressources lexicales */}
export default class LexiconContentHeader extends Component {

	render() {
		return (
			<span className="row"  id="lexiconheader">
				<TitleHeader
					metaResource   ={this.props.metaResource}
					clickEditTitle ={this.props.clickEditTitle}
					actionSaveTitleEdit ={this.props.actionSaveTitleEdit}
				/>
				<AddEntry
					modalAddArticle={this.props.modalAddArticle}
					modal={this.props.modal}
				/>
		    </span>
	    );
	}

}


LexiconContentHeader.propTypes = {
	metaResource: T.shape({
		id: T.string.isRequired,
		type: T.string.isRequired,
		lang: T.string.isRequired,
		title: T.string.isRequired,
		author: T.string.isRequired,
		editable: T.bool,
		searchable: T.bool,
		articleEditable: T.bool
	}).isRequired,
	actionSaveTitleEdit: T.func.isRequired,
	clickEditTitle: T.func.isRequired, //a revoir
	modalAddArticle: T.func.isRequired,
	modal: T.shape({
		type: T.string.isRequired,
		open: T.bool
	}).isRequired
}
