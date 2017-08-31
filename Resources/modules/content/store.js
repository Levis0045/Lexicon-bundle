import React from 'react'
import {createStore} from '#/main/core/utilities/redux'
import axios from 'axios'
import {lexiconApp} from './reducers/index'
import {makeId} from './utils'
import {jsonHtlmArticle} from './serialization/JsonHtmlArticle'
import {LoadingIndicator} from '#/main/core/loader/loading-indicator'


const container   = document.getElementById('lexicon_content')
const currentUser = JSON.parse(container.dataset['user'])
const currenturl  = window.location;
const newurl      = currenturl.pathname.split('/content/')[1];
const dicttype    = newurl.split('/')[0];
const dictname    = newurl.split('/')[1];
const dictlang    = newurl.split('/')[2];
const dictauthor  = newurl.split('/')[3];

const urlEntries  = 'http://totoro.imag.fr/lexinnova/api/'+dictname+'/'+dictlang+'/cdm-headword/a/?strategy=GREATER_THAN&sortBy=asc';
const urlAll      = 'http://totoro.imag.fr/lexinnova/api/'+dictname+'/'+dictlang+'/cdm-headword/a/entries/?strategy=GREATER_THAN&sortBy=asc';

LoadingIndicator.show()

const stateData = {}
stateData.metaResource       = {}
stateData.metaResource.id    = makeId()
stateData.metaResource.title = dictname
stateData.metaResource.type  = dicttype
stateData.metaResource.author    = dictauthor
stateData.metaResource.lang      = dictlang
stateData.metaResource.editable         = false
stateData.metaResource.searchable       = false
stateData.metaResource.articleEditable  = false
stateData.search              = {}
stateData.search.value        = ''
stateData.modal               = {}
stateData.modal.type          = 'addArticle'
stateData.modal.open          = false
stateData.currentUser         = currentUser
stateData.articles            = []
stateData.currentContentArticle  = React.createElement('div')


let lexiconStore = createStore(
    lexiconApp, 
    Object.assign({}, stateData, {currentUser})
)

axios.get(urlAll)
  .then( (response) => {
    const axiosData = response.data
    const Data = JSON.stringify(axiosData, {'d:entry-list':'d-entry-list', 'd:entry':'d-entry'})
    const re  = /d:/gi
    const re2  = /dentry-list/gi
    const newData = Data.replace(re, 'd')
    const newData2 = newData.replace(re2, 'dentrylist')
    const parseData = JSON.parse(newData2)
    generateInitialData(parseData)
  })

function generateInitialData(parseData) {
    console.log(parseData)
    const getTitle    = parseData.dentrylist
    let articles      = []
    if(parseData.dentrylist.dentry){
      const total = parseData.dentrylist.dentry.length
      let entry    = ""
      let content  = ""
      getTitle.dentry.map( (entryI, index) => {
         const nameDict = entryI.ddictionary
         const langDict = entryI.dlang
         let contrib = ''
         if(entryI.volume){
            contrib   = entryI.volume.dcontribution
         }else if (entryI.glossaire) {
           contrib  = entryI.glossaire.dcontribution
           console.log(contrib)
         }
         
         const id     = contrib.dcontribid
         const author = contrib.dmetadata.dauthor
         const entryCreation = contrib.dmetadata['dcreation-date']
         let contentArticle = ""
         let entryName      = ""
         if(contrib.ddata.article){
            entryName = contrib.ddata.article.forme.vedette
            contentArticle = jsonHtlmArticle(contrib.ddata.article)
         }else if (contrib.ddata['entrée']){
            entryName  = contrib.ddata['entrée'].terme
            const identification = "<div class='identification'><span class='vedette'>"+contrib.ddata['entrée'].terme+"</span></div>"
            const traitement     = "<div class='traitement'><span class='intro'>-- Définition : </span><p class='définition'>"+contrib.ddata['entrée']['définition']+"</p></div>"
            contentArticle = "<article class='article'>"+identification+traitement+"</article>"
         }

         if(index==0){
            entry   = entryName
            content = contentArticle
         }
         //console.log(entryName, id, author, entryCreation, contentArticle, contrib.ddata.article)
         const buildEntries  = {'entry':entryName, 'id':id, 'author': author,  'creation': entryCreation, 'content':contentArticle}

         articles.push(buildEntries)
      })

      lexiconStore.dispatch({
        type: 'ARTICLES_SET',
        articles
      })

      lexiconStore.dispatch({
        type: 'CONSULT_ARTICLE',
        entry,
        content
      })

      LoadingIndicator.hide()

    }else{
      LoadingIndicator.hide()
      return false
    }
    

   

   
}






export {lexiconStore}



//http://127.0.0.1:8000/app_dev.php/lexicon/content/Lexinnova/Lexinnova/esp/Lexinnova
//http://127.0.0.1:8000/app_dev.php/lexicon/content/Glossaire/Glossaire/fra/mangeot

/*
axios.get(urlEntries)
  .then( (response) => {
    const axiosData = response.data
    const Data = JSON.stringify(axiosData, {'d:entry-list':'d-entry-list', 'd:entry':'d-entry'})
    const re  = /d:/gi
    const re2  = /dentry-list/gi
    const newData = Data.replace(re, 'd')
    const newData2 = newData.replace(re2, 'dentrylist')
    const parseData = JSON.parse(newData2)
    generateInitialData(parseData)
  })

function generateInitialData(parseData) {
    const getTitle    = parseData.dentrylist
    const total       = parseData.dentrylist.dentry.length
    let articles = []
    getTitle.dentry.map( (entry) => { 
       const nameDict = entry.ddictionary
       const langDict = entry.dlang
       const entryhandle   = entry.dhandle
       const nameEntry     = entry.dcriteria.content
       const entryCriteria = entry.dcriteria
       const buildEntries  = {'entry':nameEntry, 'handle':entryhandle, 'editable':false, 'meta':entryCriteria}
       articles.push(buildEntries)
    })

    lexiconStore.dispatch({
      type: 'ARTICLES_SET',
      articles
    })
}

*/