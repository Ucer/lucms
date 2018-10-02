import axios from '@/libs/api.request'

export const getTableData = (to_page, per_page, searchData) => {
  return axios.request({
    url: '/api/admin/app_versions',
    params: {
      page: to_page,
      per_page: per_page,
      search_data: JSON.stringify(searchData)
    },
    method: 'get'
  })
}

export const deleteVersion = (version) => {
  return axios.request({
    url: '/api/admin/app_versions/' + version,
    method: 'delete'
  })
}

export const addVersion = (formData) => {
  return axios.request({url: '/api/admin/app_versions', data: formData, method: 'post'})
}

export const editVersion = (versionId, formData) => {
  return axios.request({
    url: '/api/admin/app_versions/' + versionId,
    data: formData,
    method: 'patch'
  })
}

export const getVersionInfoById = (version) => {
  return axios.request({
    url: 'api/admin/app_versions/' + version,
    method: 'get'
  })
}
