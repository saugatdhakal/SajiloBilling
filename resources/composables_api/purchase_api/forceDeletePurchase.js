import { ref } from '@vue/reactivity';
import axios from 'axios';

const forceDeletePurchase = () => {
    const deletedPurchase = ref({});
    const productError = ref({});
    const purchaseDeleteRequest = async (id) => {
        await axios.delete('api/purchase/forceDelete/' + id, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            deletedPurchase.value = res.data;
        }).catch((resErr) => {
            productError.value = resErr;
        })
    }
    return { deletedPurchase,productError, purchaseDeleteRequest }
}
export default forceDeletePurchase;
