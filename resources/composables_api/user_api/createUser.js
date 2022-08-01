import { ref } from '@vue/reactivity';
import axios from 'axios';


const registerUser = () => {
    const user = ref({})
    const error = ref({})


    const createUser = async (form) => {
        await axios.post('api/user/createUser', form, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((resUser) => {
            user.value = resUser.data;

            // console.log('pass', user.value);
        }).catch((resErr) => {
            error.value = resErr.response.data;
        })
    }
    return { user, error, createUser, }
}
export default registerUser;
