import http from '@/services/http.js'

export const getCollection = (url, filter, subFilter, parameter) => {

    let queryUrl = url;

    if (filter) {
        
        queryUrl += `${queryUrl.includes('?') ? '&' : '?'}filter=${parameter}:like:%${encodeURIComponent(filter)}%`
    }

    if (subFilter) {
        
        queryUrl += `${queryUrl.includes('?') ? '&' : '?'}subFilter=${parameter}:like:%${encodeURIComponent(subFilter)}%`
    }
    
    return http.get(queryUrl)
}

export const getData = (url) => {
    return http.get(url)
}

export const upstoreData = (url, id, data) => {

    let method = id ? 'patch' : 'post'
    let urlSelected = id ? `${url}/${id}` : url

    return http({ method, url: urlSelected, data: data });
}

export const deleteData = (url, id) => http.delete(`${url}/${id}`);