import { ref } from '@vue/reactivity';
import axios from 'axios';
const purchaseUpdate = () => {
    const purchase = ref({});
    const loading = ref(false);
    const purchaseError = ref({});
    const updatePurchase = async ({ id, form }) => {
        console.log(form);
        await axios.post('api/purchase/update/' + id, form, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            purchase.value = res.data;
            loading.value = false;

        }).catch((resErr) => {
            purchaseError.value = resErr;
            loading.value = false;
        })
    }
    return { purchase, purchaseError, loading, updatePurchase }
}
export default purchaseUpdate;

