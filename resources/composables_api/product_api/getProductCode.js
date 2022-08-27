import { ref } from '@vue/reactivity';
import axios from 'axios';


const getProductCode = () => {
    const productCode = ref([]);
    const pCodeLoding = ref(false);
    const productCodeError = ref({});

    const generateCode = async () => {

        axios.get('api/product/getProductCode', {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            pCodeLoding.value = false;
            productCode.value = res.data;
            console.log(productCode.value);
        }).catch((resErr) => {
            pCodeLoding.value = false;
            productCodeError.value = resErr;
        })
    }
    return { productCode, pCodeLoding, productCodeError, generateCode }
}
export default getProductCode;

