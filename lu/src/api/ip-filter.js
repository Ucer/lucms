
import axios from '@/libs/api.request'

// =============== privileges/permissions/list.vue =========================
export const getTableData = (searchData) => {
  return axios.request({
    url: '/api/admin/ip_filters',
    params: {
      search_data: JSON.stringify(searchData)
    },
    method: 'get'
  })
}

export const addEditIpFilter = (saveData) => {
  return axios.request({
    url: '/api/admin/ip_filters',
    data: saveData,
    method: 'post'
  })
}


export const deleteIpFilter = (ip_filter) => {
  return axios.request({
    url: '/api/admin/ip_filters/' + ip_filter,
    method: 'delete'
  })
}

export const getIpFilterInfoById = (ipFilterId) => {
  return axios.request({
    url: '/api/admin/ip_filters/' + ipFilterId,
    method: 'get'
  })
}
