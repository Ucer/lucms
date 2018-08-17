import axios from '@/libs/api.request'

// =============== news-system/advertisements/list.vue =========================
export const getTableData = (to_page, per_page, searchData) => {
  return axios.request({
    url: '/api/admin/advertisements',
    params: {
      page: to_page,
      per_page: per_page,
      search_data: JSON.stringify(searchData)
    },
    method: 'get'
  })
}

export const getAdvertisementPositions = () => {
  return axios.request({url: '/api/admin/advertisement_positions/all', method: 'get'})
}

export const deleteAdvertisement = (advertisement) => {
  return axios.request({
    url: '/api/admin/advertisements/' + advertisement,
    method: 'delete'
  })
}


// =============== news-system/advertisements/components/add-advertisement.vue =========================
export const addAdvertisement = (formData) => {
  return axios.request({url: '/api/admin/advertisements', data: formData, method: 'post'})
}
