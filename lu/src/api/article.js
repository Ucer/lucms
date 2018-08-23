import axios from '@/libs/api.request'

// =============== news-system/articles/list.vue =========================
export const getTableData = (to_page, per_page, searchData) => {
  return axios.request({
    url: '/api/admin/articles',
    params: {
      page: to_page,
      per_page: per_page,
      search_data: JSON.stringify(searchData)
    },
    method: 'get'
  })
}

export const getArticleCategories = () => {
  return axios.request({url: '/api/admin/categories/all', method: 'get'})
}

export const deleteArticle = (article) => {
  return axios.request({
    url: '/api/admin/articles/' + article,
    method: 'delete'
  })
}

export const addArticle = (formData) => {
  return axios.request({url: '/api/admin/articles', data: formData, method: 'post'})
}

export const editArticle = (articleId, formData) => {
  return axios.request({
    url: '/api/admin/articles/' + articleId,
    data: formData,
    method: 'patch'
  })
}

export const getArticleInfoById = (articleId) => {
  return axios.request({
    url: 'api/admin/articles/' + articleId,
    method: 'get'
  })
}
