import axios from '@/libs/api.request'

// =============== news-system/advertisement-positions/list.vue =========================
export const getTableData = (to_page, per_page, searchData) => {
  return axios.request({
    url: '/api/admin/advertisement_positions',
    params: {
      page: to_page,
      per_page: per_page,
      search_data: JSON.stringify(searchData)
    },
    method: 'get'
  })
}

export const deleteAdvertisementPosition = (advertisement_position) => {
  return axios.request({
    url: '/api/admin/advertisement_positions/' + advertisement_position,
    method: 'delete'
  })
}


export const addEditAdvertisementPosition = (saveData) => {
  return axios.request({
    url: '/api/admin/advertisement_positions',
    data: saveData,
    method: 'post'
  })
}
