import { ref } from '@vue/reactivity';
import axios from 'axios';


const registerUser = () => {
    const user = ref({})
    const error = ref(null)
    const isLoading = ref(false)

    const createUser = async (form) => {
        await axios.post('api/user/createUser', form, {
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
        })
    }
    return { user, error, createUser,isLoading }
}
export default registerUser;
