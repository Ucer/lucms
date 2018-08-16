import axios from '@/libs/api.request'

// =============== privileges/permissions/list.vue =========================
export const getTableData = (searchData) => {
  return axios.request({
    url: '/api/admin/permissions',
    params: {
      search_data: JSON.stringify(searchData)
    },
    method: 'get'
  })
}

export const addEditPermission = (saveData) => {
  return axios.request({
    url: '/api/admin/permissions',
    data: saveData,
    method: 'post'
  })
}


export const deletePermission = (permission) => {
  return axios.request({
    url: '/api/admin/permissions/' + permission,
    method: 'delete'
  })
}

// =============== privileges/permissions/components/edit-permission.vue =========================

export const getPermissionInfoById = (permission) => {
  return axios.request({
    url: '/api/admin/permissions/' + permission,
    method: 'get'
  })
}
