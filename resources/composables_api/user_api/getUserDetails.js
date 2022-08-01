import { ref } from '@vue/reactivity';
import axios from 'axios';
const getUserDetails = () => {
    let user = ref({})
    const error = ref(null)

    const getUser = async (id) => {
        await axios.get('api/user/getUserDetails/' + id, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((resUser) => {
            user.value = resUser.data;
            // console.log(user.value);
        }).catch((err) => {
            error.value = err.message;
        })
    }

    return { user, error, getUser }
}
export default getUserDetails;


