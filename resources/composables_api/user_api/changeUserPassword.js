import { ref } from '@vue/reactivity';
import axios from 'axios';

const udpateUserPassword = () => {
    const user = ref({})
    const reserror = ref(null)
    const isLoading = ref(false)

    const setPassword = async (form,id) => {
        await axios.post('api/user/updateUserPasswords/'+id, form, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((resUser) => {
            user.value = resUser.data;
            isLoading.value=true;
            console.log('pass', user.value);
        }).catch((err) => {
            isLoading.value=false;
            error.value = err.message;
            console.log =(error.value)
        })
    }
    return { user,reserror , setPassword,isLoading }
}
export default udpateUserPassword;
