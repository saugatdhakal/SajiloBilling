import { ref } from '@vue/reactivity';
import axios from 'axios';


const accountDetails = () => {
    const accounts = ref({});
    const loading = ref(true);
    const accountError = ref({});


    const getAccounts = async ({page=1,paginate,search,selectedType}) => {
        // console.log({page,paginate});
        await axios.get('api/account/getAccounts?page='+page+
        '&paginate='+paginate+
        '&q='+search+
        '&selectedType='+selectedType, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            accounts.value = res.data;
            loading.value = false;
            // console.log(accounts.value);
        }).catch((resErr) => {
            loading.value = false;
            accountError.value = resErr;
        })
    }
    return { accounts, loading, accountError, getAccounts }
}
export default accountDetails;
