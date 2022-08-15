import { ref } from '@vue/reactivity';
import axios from 'axios';


const getAccountDetails = () => {
    const account = ref({});
    const loading = ref(false);
    const accountError = ref({});


    const getDetails = async (id) => {
        await axios.get('api/account/getAccountDetails/' + id, {
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
    return { account, accountError, getDetails }
}
export default getAccountDetails;
