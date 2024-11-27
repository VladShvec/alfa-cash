import axios from 'axios'

const apiClient = axios.create({
  baseURL: 'http://localhost:8001/api/',
  headers: {
    'Content-type': 'application/json',
    'Accept': 'application/json'
  },
})

export default apiClient
