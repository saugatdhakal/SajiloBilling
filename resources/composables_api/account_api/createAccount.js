import { ref } from '@vue/reactivity';
import axios from 'axios';


const registerAccount = () => {
    const account = ref({});
    const loading = ref(false);
    const accountError = ref({});


    const createAccount = async (form) => {
        await axios.post('api/account/createAccount', form, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            
            account.value = res.data;

        }).catch((resErr) => {
            accountError.value = resErr;
        })
    }
    return { account, accountError, createAccount }
}
export default registerAccount;
