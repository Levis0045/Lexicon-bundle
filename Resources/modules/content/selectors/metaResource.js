import {createSelector} from 'reselect'
import size from 'lodash/size'


const getMetaResource  = (state) => state.metaResource

const getTitleResource = createSelector(
  [getMetaResource],
  (metaResource) => metaResource.titleResource
)

const getTypeResource  = createSelector(
  [getMetaResource],
  (metaResource) => metaResource.typeResource
)

const getIdResource  = createSelector(
  [getMetaResource],
  (metaResource) => metaResource.idResource
)

const getLangResource = createSelector(
  [getMetaResource],
  (metaResource) => metaResource.langResource
)

const getAuthorResource = createSelector(
  [getMetaResource],
  (metaResource) => metaResource.authorResource
)

const getStatusResource = createSelector(
  [getMetaResource],
  (metaResource) => metaResource.editable
)


export const select = {
	getMetaResource,
	getTitleResource,
	getTypeResource,
	getIdResource,
	getLangResource,
	getAuthorResource,
	getStatusResource
}


console.log(select)