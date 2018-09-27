import axios from '@/libs/api.request'

// =============== news-system/categories/list.vue =========================
export const getTableData = () => {
  return axios.request({url: '/api/admin/news/carousels', method: 'get'})
}

export const deleteCarousel = (carousel) => {
  return axios.request({
    url: '/api/admin/news/carousels/' + carousel,
    method: 'delete'
  })
}

export const addCarousel = (saveData) => {
  return axios.request({url: '/api/admin/news/carousels', data: saveData, method: 'post'})
}

export const editCarousel = (saveData, carouselId) => {
  return axios.request({
    url: '/api/admin/news/carousels/' + carouselId,
    data: saveData,
    method: 'patch'
  })
}


export const getCarouselInfoById = (carouselId) => {
  return axios.request({
    url: 'api/admin/news/carousels/' + carouselId,
    method: 'get'
  })
}
