
import axios from '@/libs/api.request'

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
