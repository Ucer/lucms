
import axios from '@/libs/api.request'

// =============== news-system/categories/list.vue =========================
export const getTableData = (searchData) => {
  return axios.request({
    url: '/api/admin/categories',
    params: {
      search_data: JSON.stringify(searchData)
    },
    method: 'get'
  })
}

export const deleteCategory = (category) => {
  return axios.request({
    url: '/api/admin/categories/' + category,
    method: 'delete'
  })
}

export const addEditCategory = (saveData) => {
  return axios.request({
    url: '/api/admin/categories',
    data: saveData,
    method: 'post'
  })
}
