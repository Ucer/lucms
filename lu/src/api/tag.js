import axios from '@/libs/api.request'

// =============== news-system/tags/list.vue =========================
export const getTableData = (to_page, per_page, searchData) => {
  return axios.request({
    url: '/api/admin/tags',
    params: {
      page: to_page,
      per_page: per_page,
      search_data: JSON.stringify(searchData)
    },
    method: 'get'
  })
}

export const deleteTag = (tag) => {
  return axios.request({
    url: '/api/admin/tags/' + tag,
    method: 'delete'
  })
}

export const addEditTag = (saveData) => {
  return axios.request({url: '/api/admin/tags', data: saveData, method: 'post'})
}

export const getTagInfoById = (tagId) => {
  return axios.request({
    url: 'api/admin/tags/' + tagId,
    method: 'get'
  })
}
