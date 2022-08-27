import { ref } from '@vue/reactivity';
import axios from 'axios';


const CategoriesList = () => {
    const category = ref([]);
    const loading = ref(false);
    const categoryError = ref({});

    const getCategoires = async (form) => {

        axios.get('api/category/getCategories', {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            loading.value = false;
            category.value = res.data;
            // console.log(category.value);
        }).catch((resErr) => {
            loading.value = false;
            categoryError.value = resErr;
        })
    }

    const getAscynSearch = async (searchValue) => {

        axios.get('api/category/getSearchCategories?q=' + searchValue, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            loading.value = false;
            category.value = res.data;
            // console.log(category.value);
        }).catch((resErr) => {
            loading.value = false;
            categoryError.value = resErr;
        })
    }


    return { category, loading, categoryError, getCategoires, getAscynSearch }
}
export default CategoriesList;

