import axios from 'axios';
import { ref } from 'vue';

const purchaseCreate = () => {
    const purchase = ref({});
    const createLoading = ref(false);
    const createPurchase = async (form) => {

        await axios.post('api/purchase/create', form, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            // console.log(res.data)
            createLoading.value = false;
            purchase.value = res.data;
        }).catch((err) => {
            console.log(err);
         }
        );
    }
    return { createPurchase, purchase, createLoading };
}

export default purchaseCreate;
