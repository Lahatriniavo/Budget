// src/services/authService.js
import api from './api';
import axios from 'axios';

export const login = (credentials) => api.post('/login', credentials);
export const register = (data) => api.post('/register', data);
export function logout() {
  const token = localStorage.getItem('token');
  return axios.post('http://localhost:8000/api/logout', {}, {
    headers: {
      Authorization: `Bearer ${token}`
    }
  });
}