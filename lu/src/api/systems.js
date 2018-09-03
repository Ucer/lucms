import axios from '@/libs/api.request'

// =============== resources/systems/config-item-list.vue =========================
export const getTableData = (searchData) => {
  return axios.request({
    url: '/api/admin/system_configs',
    params: {
      search_data: JSON.stringify(searchData)
    },
    method: 'get'
  })
}

export const getGroup = () => {
  return axios.request({url: '/api/admin/system_configs/get_group', method: 'get'})
}

export const deleteSystemConfig = (systemConfig) => {
  return axios.request({
    url: '/api/admin/system_configs/' + systemConfig,
    method: 'delete'
  })
}

export const addSystemConfig = (formData) => {
  return axios.request({url: '/api/admin/system_configs', data: formData, method: 'post'})
}

export const editSystemConfig = (systemConfigId, formData) => {
  return axios.request({
    url: '/api/admin/system_configs/' + systemConfigId,
    data: formData,
    method: 'patch'
  })
}

export const getSystemConfigInfoById = (systemConfigId) => {
  return axios.request({
    url: 'api/admin/system_configs/' + systemConfigId,
    method: 'get'
  })
}
