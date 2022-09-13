import { ref } from '@vue/reactivity';
import axios from 'axios';
const softDeletePurchase = () => {
    const softDeleteData = ref([]);
    const deleteLoading = ref(false);
    const deletedError = ref({});
    const deletePurchase = async (id) => {
        axios.delete('api/purchase/softDelete/' + id, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            deleteLoading.value = false;
            softDeleteData.value = res.data;
            // console.log(PurchaseCode.value);
        }).catch((resErr) => {
            deleteLoading.value = false;
            deletedError.value = resErr;
        })
    }
    return { softDeleteData, deleteLoading, deletedError, deletePurchase }
}
export default softDeletePurchase;
