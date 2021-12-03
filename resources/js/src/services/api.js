// import axios from 'axios'

// const BaseApi = axios.create({
//   baseURL: 'http://127.0.0.1:8000/api/',
//   withCredentials: true,
// })

// export default BaseApi
import axios from 'axios'

const BaseApi = axios.create({
  baseURL: 'http://127.0.0.1:8000/api',
})

const Api = () => BaseApi

export default Api
