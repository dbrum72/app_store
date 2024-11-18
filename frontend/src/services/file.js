import http from '@/services/http.js';

const url = `${process.env.VUE_APP_BACKEND_URL}/product_file`

const urlFiles = process.env.VUE_APP_BACKEND_URL_FILES

export const getFile = (file)=> { return urlFiles + file}

export const storeFile = (id, file) => http.post(url, { 'file': file, 'product_id': id }, { headers: { 'Content-Type': 'multipart/form-data' } })

export const deleteFile = (id) => http.delete(`${url}/${id}`)