import http from '@/services/http.js'

export const getCollection = (url, filter, extendFilter, parameter, sort) => {

    let queryUrl = url;
    
    if (filter) {
        
        queryUrl += `${queryUrl.includes('?') ? '&' : '?'}filter=${parameter}:like:%${encodeURIComponent(filter)}%`
    }

    if (extendFilter) {
        
        const extendParameter = extendFilter.split(',')
        
        queryUrl += `${queryUrl.includes('?') ? '&' : '?'}extendedFilter=${extendParameter[0]},${encodeURIComponent(parameter)}:like:%${extendParameter[1]}%`
    }

    if (sort) {
        queryUrl += `${queryUrl.includes('?') ? '&' : '?'}sort=${sort}`
    }

    console.log(queryUrl)
    
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