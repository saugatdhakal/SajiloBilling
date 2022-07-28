import { defineStore } from 'pinia';
import axios from 'axios';
import router from '../router';

export const authState = defineStore('authication', {
    state: () => ({
        isAuth: false,
        returnUrl: null
    }),
    actions: {
        async LoginEvent(form) {
            try {
                await axios.post('api/login', form).then((responde) => {
                    if (responde.data.authorisation.token) {
                        localStorage.setItem('token', responde.data.authorisation.token);
                        this.isAuth = true;
                        console.log(localStorage.getItem('token'), this.isAuth);
                        router.push(this.returnUrl || '/')
                    }
                }).catch(function (error) {
                    if (error.response) {
                        return false;
                    } else if (error.request) {
                        return false;
                    } else {
                        return false;
                    }

                });;

                ;
            } catch (error) {
                return false;
            }
        },
        checkLogin() {
            if (localStorage.getItem('token')) {
                this.isAuth = true;
                router.push({ name: 'home' })
            }
            else {
                router.push('/login')
                this.isAuth = false;

            }
        },
        async logout() {
            await axios.post('api/logout', '', {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`,
                    Accept: 'application/json',
                }
            }).then(
                (responde) => {
                    if (localStorage.getItem('token')) {
                        localStorage.setItem('token', '');
                        this.isAuth = false;
                        router.push('/login')
                    }
                }
            );
        }
    }
}

);



