import { defineStore } from 'pinia'
import { ref, computed, watch  } from 'vue'
import { useForm, usePage, Head, Link, router } from '@inertiajs/vue3'
import axios from 'axios'

export const useMainStore = defineStore('main', () => {



  const userName = ref('John Doe')
  const userEmail = ref('doe.doe.doe@example.com')

  const userAvatar = computed(
    () =>
      `https://api.dicebear.com/7.x/avataaars/svg?seed=${userEmail.value.replace(
        /[^a-z0-9]+/gi,
        '-'
      )}`
  )

  const isFieldFocusRegistered = ref(false)

  const clients = ref([])
  const history = ref([])


  const toast = ref("");

  watch(toast, toastFunction);

  const show_search_box = ref(false);
  watch(show_search_box, watchShowSearchBox);



  const show_noti_box = ref(false)
  const post_deleted_evt = ref(false)
  const show_nav_menu = ref(false)
  const useSearchBtn = ref(true)
  const is_admin = ref(false)
  const notiDismissed = ref(true)
  const email_changed = ref(false)
  const sidebar_open = ref(false)
  const post_like_loading = ref(false)
  const comments_like_loading = ref(false)
  const replies_like_loading = ref(false)


  const show_post_likes_modal = ref(false)
  const post_likes = ref([])
  const current_post_id = ref(null)
  const loading_post_likes = ref(false)
  const last_post_like = ref(false)

  const show_comment_likes_modal = ref(false)
  const comment_likes = ref([])
  const current_comment_id = ref(null)
  const loading_comment_likes = ref(false)
  const last_comment_like = ref(false)

  const show_reply_likes_modal = ref(false)
  const reply_likes = ref([])
  const current_reply_id = ref(null)
  const loading_reply_likes = ref(false)
  const last_reply_like = ref(false)

  const show_post_more_options_modal = ref(false);
  const current_post = ref(null);
  const current_post_index = ref(null);

  const show_comment_more_options_modal = ref(false);
  const current_comment = ref(null);
  const current_comment_index = ref(null);

  const show_reply_more_options_modal = ref(false);
  const current_reply = ref(null);
  const current_reply_index = ref(null);

  const show_about_user_modal = ref(false);

  const current_follwers_user_id = ref(null);
  const show_user_followers_modal = ref(false);
  const loading_user_followers = ref(false)
  const user_followers = ref([])
  const last_user_follower = ref(false)

  const current_following_user_id = ref(null);
  const show_user_following_modal = ref(false);
  const loading_user_following = ref(false)
  const user_following = ref([])
  const last_user_following = ref(false)

  const recent_search_loading = ref(false)
  const recent_searches = ref([]);

  const search_loading = ref(false)
  const search_results = ref([]);

  const deleting_all_recent = ref(false)
  const delete_recent_search_loading = ref(false)

  const show_community_more_options_modal = ref(false)
  const community_details_global = ref({})

  const show_community_leader_form_modal = ref(false)

  const current_community_id = ref(null);

  const show_community_residents_modal = ref(false)
  const loading_community_residents = ref(false)
  const community_residents = ref([])
  const last_community_resident = ref(false)

  const show_community_leaders_modal = ref(false)
  const loading_community_leaders = ref(false)
  const community_leaders = ref({kings: [], chiefs: [], cabinet_members: []})
  const last_community_leader = ref(false)

  const show_manage_community_history_modal = ref(false)

  const show_community_history_modal = ref(false)

  const show_upload_community_image_modal = ref(false)

  const show_form_box = ref(false)

  const make_comment_form = useForm({
    comment: "",
    mode: "comment",
  })

  const search_value = ref("");

  watch(search_value, watchSearchValue)


  watch(
    () => make_comment_form.comment, // use a getter like this
    (comment) => {
       if(make_comment_form.mode == "reply" && comment == ""){
            toast.value = "Reverting to comment mode";
            resetMakeCommentForm();
        }
    }
  )

  function closeCommunityImageModal() {
    community_details_global.value = {};
    show_upload_community_image_modal.value = false;
  }

  function newCommunityGalleryImage() {
    show_upload_community_image_modal.value = true;
    show_community_more_options_modal.value  = false
  }

  async function viewCommunityHistory(community_id = null) {
    current_community_id.value = community_id == null ? current_community_id.value : community_id
    show_community_leaders_modal.value = true;
    try {
      if(loading_community_leaders.value){
        return
      }


      loading_community_leaders.value = true;


      let queryRoute = route('community.leaders_list', {community: current_community_id.value});

      const response = await axios.post(queryRoute, { load_leaders: true });
      console.log(response)
      loading_community_leaders.value = false;

      if (response.data.success) {

        community_leaders.value = response.data.leaders;


        console.log(community_leaders.value)


      } else {
        toast.value = 'Something went wrong'
      }
    } catch (error) {

      loading_community_leaders.value = false;
      if (error.response) {
        // Request made but the server responded with an error
        var status = error.response.status;
        if (status == 419) {
          document.location.reload()

        }

      } else if (error.request) {
        // Request made but no response is received from the server.
      } else {
        // Error occured while setting up the request
      }

      toast.value = 'Something went wrong'
      console.log('Something went wrong' + error)


      // Swal.fire({
      //   title: 'Ooops!',
      //   html: 'Something went wrong',
      //   icon: 'error',


      // });
    }
  }

  function closeCommunityHistoryModal() {
    community_details_global.value = {};
    show_manage_community_history_modal.value = false;
  }

  function manageCommunityHistory() {
    show_manage_community_history_modal.value = true;
    show_community_more_options_modal.value  = false
  }

  function closeCommunityLeadersModal() {
    community_leaders.value = {kings: [], chiefs: [], cabinet_members: []};
    current_community_id.value = null;
    show_community_leaders_modal.value = false;
    loading_community_leaders.value = false;
    last_community_leader.value = false;
  }

  async function loadAllCommunityLeaders(community_id = null) {
    current_community_id.value = community_id == null ? current_community_id.value : community_id
    show_community_leaders_modal.value = true;
    try {
      if(loading_community_leaders.value){
        return
      }


      loading_community_leaders.value = true;


      let queryRoute = route('community.leaders_list', {community: current_community_id.value});

      const response = await axios.post(queryRoute, { load_leaders: true });
      console.log(response)
      loading_community_leaders.value = false;

      if (response.data.success) {

        community_leaders.value = response.data.leaders;


        console.log(community_leaders.value)


      } else {
        toast.value = 'Something went wrong'
      }
    } catch (error) {

      loading_community_leaders.value = false;
      if (error.response) {
        // Request made but the server responded with an error
        var status = error.response.status;
        if (status == 419) {
          document.location.reload()

        }

      } else if (error.request) {
        // Request made but no response is received from the server.
      } else {
        // Error occured while setting up the request
      }

      toast.value = 'Something went wrong'
      console.log('Something went wrong' + error)


      // Swal.fire({
      //   title: 'Ooops!',
      //   html: 'Something went wrong',
      //   icon: 'error',


      // });
    }
  }


  function closeCommunityResidentsModal() {
    community_residents.value = [];
    current_community_id.value = null;
    show_community_residents_modal.value = false;
    loading_community_residents.value = false;
    last_community_resident.value = false;
  }

  async function loadAllCommunityResidents(community_id = null) {
    current_community_id.value = community_id == null ? current_community_id.value : community_id
    show_community_residents_modal.value = true;
    try {
      if(loading_community_residents.value){
        return
      }


      loading_community_residents.value = true;
      var last_id = community_residents.value.length > 0 ? community_residents.value[community_residents.value.length - 1].id : 0

      let queryRoute = route('community.residents_list', {community: current_community_id.value});

      const response = await axios.post(queryRoute, { last_id: last_id });
      console.log(response)
      loading_community_residents.value = false;

      if (response.data.success) {
        if(response.data.residents.length > 0){
          community_residents.value = community_residents.value.concat(response.data.residents);
          last_community_resident.value = response.data.last_resident;

          console.log(community_residents.value)
        }else{
          toast.value = 'No residents in this community'
        }

      } else {
        toast.value = 'Something went wrong'
      }
    } catch (error) {

      loading_community_residents.value = false;
      if (error.response) {
        // Request made but the server responded with an error
        var status = error.response.status;
        if (status == 419) {
          document.location.reload()

        }

      } else if (error.request) {
        // Request made but no response is received from the server.
      } else {
        // Error occured while setting up the request
      }

      toast.value = 'Something went wrong'
      console.log('Something went wrong' + error)


      // Swal.fire({
      //   title: 'Ooops!',
      //   html: 'Something went wrong',
      //   icon: 'error',


      // });
    }
  }

  function closeCommunityLeaderFormModal() {
    community_details_global.value = {};
    show_community_leader_form_modal.value = false;
  }





  function applyAsCommunityLeader() {
    show_community_leader_form_modal.value = true;
    show_community_more_options_modal.value  = false
  }

  function closeCommunityMoreOptionsModal() {
    community_details_global.value = {};
    show_community_more_options_modal.value = false;
  }


  async function showCommunityMoreOptions(community, auth_user, community_details, position, roles) {
    community_details_global.value.community = community
    community_details_global.value.user = auth_user
    community_details_global.value.community_details = community_details
    community_details_global.value.position = position
    community_details_global.value.roles = roles



    community_details_global.value.roles.unshift({id: 0, name: '---Select Role----'})
    console.log(community_details_global.value.roles)

    community_details_global.value.loading = false


    show_community_more_options_modal.value = true;


  }

  function hideSearchFormBox() {
    show_form_box.value = false;
  }

  function showSearchFormBox() {
    show_form_box.value = true;
  }

  function toggleSearchFormBox() {
    show_form_box.value = !show_form_box.value;
  }

  function deleteAllRecentSearches() {
    Swal.fire({
        title: `Are you sure you want to delete all your recent searches?`,
        html: '<b class="text-primary-100">Note: This process is irreversible</b>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes Proceed!',
      }).then((result) => {

        if (result.isConfirmed) {
            clearAllRecentSearches()

        } else if (result.isDenied) {
          // Swal.fire('Changes are not saved', '', 'info')
        }
      })
  }


  async function clearAllRecentSearches() {

    // recent_searches.value = [];

    try {
      if(deleting_all_recent.value){
        return
      }


      deleting_all_recent.value = true;

      let queryRoute = route('search.delete_recent_all');

      const response = await axios.post(queryRoute, { delete_all: true });
      console.log(response)
      deleting_all_recent.value = false;

      if (response.data.success) {

        recent_searches.value = [];
        toast.value = 'All recent search cleared'
        console.log(recent_searches.value)

      } else {
        toast.value = 'Something went wrong'
      }
    } catch (error) {

        deleting_all_recent.value = false;
      if (error.response) {
        // Request made but the server responded with an error
        var status = error.response.status;
        if (status == 419) {
          document.location.reload()

        }

      } else if (error.request) {
        // Request made but no response is received from the server.
      } else {
        // Error occured while setting up the request
      }

      toast.value = 'Something went wrong'
      console.log('Something went wrong' + error)


      // Swal.fire({
      //   title: 'Ooops!',
      //   html: 'Something went wrong',
      //   icon: 'error',


      // });
    }
  }



  async function clearSingleRecentSearch(index) {

    // recent_searches.value = [];
    let recent = recent_searches.value[index];
    try {
      if(recent.deleting_search){
        return
      }


      recent.deleting_search = true;

      let queryRoute = route('search.delete_recent', {id: recent.id});

      const response = await axios.post(queryRoute, { load_search: true });
      console.log(response)
      recent.deleting_search = false;

      if (response.data.success) {

        recent_searches.value.splice(index, 1);
        toast.value = 'Recent search cleared'
        console.log(recent_searches.value)

        if(recent_searches.value.length == 0){
            refreshRecentSearch();
        }

      } else {
        toast.value = 'Something went wrong'
      }
    } catch (error) {

        recent.deleting_search = false;
      if (error.response) {
        // Request made but the server responded with an error
        var status = error.response.status;
        if (status == 419) {
          document.location.reload()

        }

      } else if (error.request) {
        // Request made but no response is received from the server.
      } else {
        // Error occured while setting up the request
      }

      toast.value = 'Something went wrong'
      console.log('Something went wrong' + error)


      // Swal.fire({
      //   title: 'Ooops!',
      //   html: 'Something went wrong',
      //   icon: 'error',


      // });
    }
  }

  function watchSearchValue() {
    if(search_value.value.length > 0){

      runSearch();
    }
  }

   function runSearch() {

    // recent_searches.value = [];

    if(search_loading.value){
        return
    }


    search_loading.value = true;

    let url = route('search.run_search');

    const options = {
        url: url,
        method: 'POST',

        data: {
            param: search_value.value,
        }
    };

    axios(options)
        .then(response => {
            search_loading.value = false;
            console.log(response);
            if (response.data.success) {
                search_results.value = [];
                if(Array.from(search_value.value)[0] == "#"){
                    search_results.value = search_results.value.concat({
                        user_id: response.data.user_id,
                        type: 'tag',
                        search: `${search_value.value}`,
                        searched_user_id:  null,
                    });
                }else{
                    search_results.value = search_results.value.concat({
                        user_id: response.data.user_id,
                        type: 'search',
                        search: `${search_value.value}`,
                        searched_user_id:  null,
                    });
                }

                search_results.value = search_results.value.concat(response.data.results);
                console.log(search_results.value)

            } else {
                toast.value = 'Something went wrong'
            }
        })
        .catch(function (error) {
            // handle error
            console.log(error);

            search_loading.value = false;
            if (error.response) {

                var status = error.response.status;
                if (status == 419) {
                document.location.reload()

                }

            } else if (error.request) {

            } else {

            }

            toast.value = 'Something went wrong'
            console.log('Something went wrong' + error)


            Swal.fire({
            title: 'Ooops!',
            html: 'Something went wrong',
            icon: 'error',


            });
        });


  }

  async function refreshRecentSearch() {

    // recent_searches.value = [];
    try {
      if(recent_search_loading.value){
        return
      }


      recent_search_loading.value = true;

      let queryRoute = route('search.recent');

      const response = await axios.post(queryRoute, { load_search: true });
      console.log(response)
      recent_search_loading.value = false;

      if (response.data.success) {

        recent_searches.value = response.data.recent_searches;
        console.log(recent_searches.value)

      } else {
        toast.value = 'Something went wrong'
      }
    } catch (error) {

        recent_search_loading.value = false;
      if (error.response) {
        // Request made but the server responded with an error
        var status = error.response.status;
        if (status == 419) {
          document.location.reload()

        }

      } else if (error.request) {
        // Request made but no response is received from the server.
      } else {
        // Error occured while setting up the request
      }

      toast.value = 'Something went wrong'
      console.log('Something went wrong' + error)


      // Swal.fire({
      //   title: 'Ooops!',
      //   html: 'Something went wrong',
      //   icon: 'error',


      // });
    }
  }

  function watchShowSearchBox (){
    if(show_search_box.value){
      refreshRecentSearch();
    }
  }

  function showSearchBox(){
    show_search_box.value = true
  }

  function hideSearchBox(){
    show_search_box.value = false
  }

  function toggleSearchBox(){
    show_search_box.value = !show_search_box.value
  }


  function showNotiBox(){
    show_noti_box.value = true
  }

  function hideNotiBox(){
    show_noti_box.value = false
  }

  function toggleNotiBox(){
    show_noti_box.value = !show_noti_box.value
  }

  function searchTextForHashTags(text) {
    const regex = /#(\w+)/g;

    return text.replace(regex, (match, group) => {
      return `<a href='/tags/${group}' class='hover:underline ml-1 text-primary-100 inline-block'>${match}</a>`;
    });
  }

  function stripHtml(html)
  {
    let tmp = document.createElement("DIV");
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || "";
  }

  function closeUserFollowingModal() {
    user_following.value = [];
    current_following_user_id.value = null;
    show_user_following_modal.value = false;
    loading_user_following.value = false;
    last_user_following.value = false;
  }

  async function loadUserFollowing(user_slug = null) {
    current_following_user_id.value = user_slug == null ? current_following_user_id.value : user_slug
    show_user_following_modal.value = true;
    try {
      if(loading_user_following.value){
        return
      }


      loading_user_following.value = true;
      var last_id = user_following.value.length > 0 ? user_following.value[user_following.value.length - 1].id : 0

      let queryRoute = route('profile.following.show', {user: current_following_user_id.value});

      const response = await axios.post(queryRoute, { last_id: last_id });
      console.log(response)
      loading_user_following.value = false;

      if (response.data.success) {
        if(response.data.following.length > 0){
            user_following.value = user_following.value.concat(response.data.following);
            last_user_following.value = response.data.last_following;

            console.log(user_following.value)
        }else{
            toast.value = 'No following'
        }

      } else {
        toast.value = 'Something went wrong'
      }
    } catch (error) {

      loading_user_following.value = false;
      if (error.response) {
        // Request made but the server responded with an error
        var status = error.response.status;
        if (status == 419) {
          document.location.reload()

        }

      } else if (error.request) {
        // Request made but no response is received from the server.
      } else {
        // Error occured while setting up the request
      }

      toast.value = 'Something went wrong'
      console.log('Something went wrong' + error)


      // Swal.fire({
      //   title: 'Ooops!',
      //   html: 'Something went wrong',
      //   icon: 'error',


      // });
    }
  }

  function closeUserFollowerssModal() {
    user_followers.value = [];
    current_follwers_user_id.value = null;
    show_user_followers_modal.value = false;
    loading_user_followers.value = false;
    last_user_follower.value = false;
  }

  async function loadUserFollowers(user_slug = null) {
    current_follwers_user_id.value = user_slug == null ? current_follwers_user_id.value : user_slug
    show_user_followers_modal.value = true;
    try {
      if(loading_user_followers.value){
        return
      }


      loading_user_followers.value = true;
      var last_id = user_followers.value.length > 0 ? user_followers.value[user_followers.value.length - 1].id : 0

      let queryRoute = route('profile.followers.show', {user: current_follwers_user_id.value});

      const response = await axios.post(queryRoute, { last_id: last_id });
      console.log(response)
      loading_user_followers.value = false;

      if (response.data.success) {
        if(response.data.followers.length > 0){
            user_followers.value = user_followers.value.concat(response.data.followers);
            last_user_follower.value = response.data.last_follower;
        }else{
            toast.value = 'No followers'
        }

      } else {
        toast.value = 'Something went wrong'
      }
    } catch (error) {

      loading_user_followers.value = false;
      if (error.response) {
        // Request made but the server responded with an error
        var status = error.response.status;
        if (status == 419) {
          document.location.reload()

        }

      } else if (error.request) {
        // Request made but no response is received from the server.
      } else {
        // Error occured while setting up the request
      }

      toast.value = 'Something went wrong'
      console.log('Something went wrong' + error)


      // Swal.fire({
      //   title: 'Ooops!',
      //   html: 'Something went wrong',
      //   icon: 'error',


      // });
    }
  }


//   function convertKbTMb(val) {
//     // return (val / 1024).toFixed(2);
//   };

  async function deleteCommentReply(reply) {
    try {

        if(reply.deleting_loading){
          return
        }


        reply.deleting_loading = true;

        let queryRoute = route('reply.destroy', {reply: reply.id});

        const response = await axios.post(queryRoute);
        console.log(response)
        reply.deleting_loading = false;

        if (response.data.success) {

            current_comment.value.replies.splice(current_reply_index, 1);
            toast.value = 'Reply deleted successfully'
            closeCommentReplyMoreOptionsModal();
        } else {
          toast.value = 'Something went wrong'
        }
    } catch (error) {

        reply.deleting_loading = false;
        if (error.response) {
            // Request made but the server responded with an error
            var status = error.response.status;
            if (status == 419) {
            document.location.reload()

            }

        } else if (error.request) {
            // Request made but no response is received from the server.
        } else {
            // Error occured while setting up the request
        }

        console.log('Something went wrong' + error)
        toast.value = 'Something went wrong'



    }
  }

 function closeCommentReplyMoreOptionsModal (){
    current_post.value = null;
    current_comment.value = null;
    current_reply.value = null;
    current_comment_index.value = null;
    current_reply_index.value = null;
    show_reply_more_options_modal.value = false;
  }

  function loadCommentReplyMoreOptions (post, comment, reply, comment_index, reply_index){
    console.log(reply)
    current_post.value = post;
    current_comment.value = comment;
    current_reply.value = reply;
    current_comment_index.value = comment_index;
    current_reply_index.value = reply_index;
    show_reply_more_options_modal.value = true;
  }


  function resetMakeCommentForm() {
    current_post.value = null;
    current_comment.value = null;
    current_comment_index.value = null;
    make_comment_form.mode = "comment";
    make_comment_form.comment = ""
  }

  function makeReply(post, comment, comment_index) {
    current_post.value = post;
    current_comment.value = comment;
    current_comment_index.value = comment_index;
    make_comment_form.mode = "reply";

    toast.value = "Reply mode";
    make_comment_form.comment = `@${current_comment.value.user.user_name} `
  }

  function makeComment (post) {
    current_post.value = post;
    if(make_comment_form.processing){
      return
    }

    let url = make_comment_form.mode == "comment" ? route('comment.store', current_post.value.id) : route('reply.store', current_comment.value.id)
    make_comment_form.post(url, {
      preserveScroll: true,
      onSuccess: (page) => {

        var response = page.props.flash.data;
        console.log(response)
        if (response.success) {

          var new_comment = [response.comment];
          toast.value = `${make_comment_form.mode == "comment" ? "Comment" : "Reply"} made successfully.`;
          if(make_comment_form.mode == "comment"){
            current_post.value.comments = new_comment.concat(current_post.value.comments)
          }else{
            current_comment.value.replies = new_comment.concat(current_comment.value.replies)
          }


          resetMakeCommentForm()

        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: `Something went wrong`,
          })
        }
      }, onError: (errors) => {
        console.log(errors)

        if(Object.keys(errors).length > 0){




          var issues = `<h4 class="text-xl mb-3">Please fix the issues below </h4>`;
          Object.keys(errors).map(function(objectKey, index) {
            var value = errors[objectKey];
            issues += `<h5 class="text-lg capitalize"><em class="text-primary-100 font-bold">${value}</em></h5>`;
          });
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: issues,
          })
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: `Something went wrong`,
          })
        }


      },
    });


  }

  async function deleteComment(comment) {
    try {

        if(comment.deleting_loading){
          return
        }


        comment.deleting_loading = true;

        let queryRoute = route('comment.destroy', {comment: comment.id});

        const response = await axios.post(queryRoute);
        console.log(response)
        comment.deleting_loading = false;

        if (response.data.success) {

            current_post.value.comments.splice(current_comment_index, 1);
            toast.value = 'Comment deleted successfully'
            closeCommentMoreOptionsModal();
        } else {
          toast.value = 'Something went wrong'
        }
    } catch (error) {

        comment.deleting_loading = false;
        if (error.response) {
            // Request made but the server responded with an error
            var status = error.response.status;
            if (status == 419) {
            document.location.reload()

            }

        } else if (error.request) {
            // Request made but no response is received from the server.
        } else {
            // Error occured while setting up the request
        }

        console.log('Something went wrong' + error)
        toast.value = 'Something went wrong'



    }
  }

  function closeCommentMoreOptionsModal (){
    current_post.value = null;
    current_comment.value = null;
    current_comment_index.value = null;
    show_comment_more_options_modal.value = false;
  }


  function loadCommentMoreOptions (post, comment, comment_index){
    current_post.value = post;
    current_comment.value = comment;
    current_comment_index.value = comment_index;
    show_comment_more_options_modal.value = true;
  }

  function formatNumbers (num) {
    return num < 10 ? "0" + num : num;
  }

  function formatDate (date, format = true) {
    // console.log(date)
    if(date == null){return ""}
    date = new Date(date);

    // console.log(mnth);
    let day = formatNumbers(date.getDate());
    // let month = this.formatNumbers(date.getMonth() + 1);
    let month = date.toLocaleString('default', { month: 'short' });
    let year = date.getFullYear()

    let hour = formatNumbers(date.getHours() - 1);
    let minute = formatNumbers(date.getMinutes());
    let seconds = formatNumbers(date.getSeconds());
    let hour_minute = date.toLocaleString('default', { hour: 'numeric', minute: 'numeric', hour12: true })
    // console.log(date)
    // return format ? day + ' ' + month + ' ' + year + ' ' + hour_minute : day + ' ' + month + ' ' + year;
    return format ? day + ' ' + month + ' ' + year + ' ' + hour_minute : day + ' ' + month + ' ' + year;

  }

  async function refreshUserDetails(user) {
    try {

        if(user.about_user_loading){
          return
        }


        user.about_user_loading = true;

        let queryRoute = route('user.load_details', {user: user.id});

        const response = await axios.get(queryRoute);
        console.log(response)
        user.about_user_loading = false;

        if (response.data.success && response.data.user != "") {

          return response.data.user;

        } else {
          toast.value = 'Something went wrong'
        }
    } catch (error) {

    user.about_user_loading = false;
    if (error.response) {
        // Request made but the server responded with an error
        var status = error.response.status;
        if (status == 419) {
        document.location.reload()

        }

    } else if (error.request) {
        // Request made but no response is received from the server.
    } else {
        // Error occured while setting up the request
    }

    console.log('Something went wrong' + error)
    toast.value = 'Something went wrong'

    // Swal.fire({
    //   title: 'Ooops!',
    //   html: 'Something went wrong',
    //   icon: 'error',


    // });
    }
  }

  function closeAboutAccountModal(){
    show_about_user_modal.value = false;
    show_post_more_options_modal.value = true;
  }

  async function aboutAccount (user) {
    // try{
        // user = await refreshUserDetails(user);

    // }catch (err){
    //     toast.value = 'Could not load user data'
    // }

    show_post_more_options_modal.value = false;
    show_about_user_modal.value = true;
  }

  function copyPostLink (post) {
    var link = route('post.show', post.id);

    copyText(link);
  }

  function copyText(text){
    navigator.clipboard.writeText(text);
    toast.value = 'Copied to clipboard'
  }

  function sharePost (post) {

  }

  async function addPostToFavorites (post) {
    try {

        if(post.favorite_loading){
          return
        }


        post.favorite_loading = true;

        let queryRoute = route('post.toggle_favorite', {post: post.id});

        const response = await axios.post(queryRoute);
        console.log(response)
        post.favorite_loading = false;

        if (response.data.success && response.data.action != "") {

          post.is_favorite = response.data.action == "favorited" ? true : false;
          toast.value = response.data.action == "favorited" ? 'Added to favorites' : 'Removed from favorites';
        } else {
          toast.value = 'Something went wrong'
        }
    } catch (error) {

    post.favorite_loading = false;
    if (error.response) {
        // Request made but the server responded with an error
        var status = error.response.status;
        if (status == 419) {
        document.location.reload()

        }

    } else if (error.request) {
        // Request made but no response is received from the server.
    } else {
        // Error occured while setting up the request
    }

    console.log('Something went wrong' + error)
    toast.value = 'Something went wrong'

    // Swal.fire({
    //   title: 'Ooops!',
    //   html: 'Something went wrong',
    //   icon: 'error',


    // });
    }

  }

  function closePostMoreOptionsModal (){
    current_post.value = null;
    show_post_more_options_modal.value = false;
  }

  function loadPostMoreOptions(post, index){
    current_post.value = post;
    current_post_index.value = index;
    show_post_more_options_modal.value = true;
  }

  async function loadReplyLikes(reply_id = null) {
    current_reply_id.value = reply_id == null ? current_reply_id.value : reply_id
    show_reply_likes_modal.value = true;
    try {
      if(loading_reply_likes.value){
        return
      }


      loading_reply_likes.value = true;
      var last_id = reply_likes.value.length > 0 ? reply_likes.value[reply_likes.value.length - 1].id : 0

      let queryRoute = route('reply.likes.show', {id: current_reply_id.value});

      const response = await axios.post(queryRoute, { last_id: last_id });
      console.log(response)
      loading_reply_likes.value = false;

      if (response.data.success && response.data.likes.length > 0) {

        reply_likes.value = reply_likes.value.concat(response.data.likes);
        last_reply_like.value = response.data.last_like;

      } else {
        toast.value = 'Something went wrong'
      }
    } catch (error) {

      loading_reply_likes.value = false;
      if (error.response) {
        // Request made but the server responded with an error
        var status = error.response.status;
        if (status == 419) {
          document.location.reload()

        }

      } else if (error.request) {
        // Request made but no response is received from the server.
      } else {
        // Error occured while setting up the request
      }

      toast.value = 'Something went wrong'
      console.log('Something went wrong' + error)


      // Swal.fire({
      //   title: 'Ooops!',
      //   html: 'Something went wrong',
      //   icon: 'error',


      // });
    }
  }

  async function loadCommentLikes(comment_id = null) {
    current_comment_id.value = comment_id == null ? current_comment_id.value : comment_id
    show_comment_likes_modal.value = true;
    try {
      if(loading_comment_likes.value){
        return
      }


      loading_comment_likes.value = true;
      var last_id = comment_likes.value.length > 0 ? comment_likes.value[comment_likes.value.length - 1].id : 0

      let queryRoute = route('comment.likes.show', {id: current_comment_id.value});

      const response = await axios.post(queryRoute, { last_id: last_id });
      console.log(response)
      loading_comment_likes.value = false;

      if (response.data.success && response.data.likes.length > 0) {

        comment_likes.value = comment_likes.value.concat(response.data.likes);
        last_comment_like.value = response.data.last_like;

      } else {
        toast.value = 'Something went wrong'
      }
    } catch (error) {

      loading_comment_likes.value = false;
      if (error.response) {
        // Request made but the server responded with an error
        var status = error.response.status;
        if (status == 419) {
          document.location.reload()

        }

      } else if (error.request) {
        // Request made but no response is received from the server.
      } else {
        // Error occured while setting up the request
      }

      toast.value = 'Something went wrong'
      console.log('Something went wrong' + error)


      // Swal.fire({
      //   title: 'Ooops!',
      //   html: 'Something went wrong',
      //   icon: 'error',


      // });
    }
  }

  async function loadPostLikes(post_id = null) {
    current_post_id.value = post_id == null ? current_post_id.value : post_id
    show_post_likes_modal.value = true;
    try {
      if(loading_post_likes.value){
        return
      }


      loading_post_likes.value = true;
      var last_id = post_likes.value.length > 0 ? post_likes.value[post_likes.value.length - 1].id : 0

      let queryRoute = route('post.likes.show', {id: current_post_id.value});

      const response = await axios.post(queryRoute, { last_id: last_id });
      console.log(response)
      loading_post_likes.value = false;

      if (response.data.success && response.data.likes.length > 0) {

        post_likes.value = post_likes.value.concat(response.data.likes);
        last_post_like.value = response.data.last_like;

      } else {
        toast.value = 'Something went wrong'
      }
    } catch (error) {

      loading_post_likes.value = false;
      if (error.response) {
        // Request made but the server responded with an error
        var status = error.response.status;
        if (status == 419) {
          document.location.reload()

        }

      } else if (error.request) {
        // Request made but no response is received from the server.
      } else {
        // Error occured while setting up the request
      }

      toast.value = 'Something went wrong'
      console.log('Something went wrong' + error)


      // Swal.fire({
      //   title: 'Ooops!',
      //   html: 'Something went wrong',
      //   icon: 'error',


      // });
    }
  }

  function toastFunction (){
    if(toast.value != ""){
      setTimeout(() => {
        toast.value = "";
      }, 5000);
    }
  }

  function closeReplyLikesModal() {
    reply_likes.value = [];
    current_reply_id.value = null;
    show_reply_likes_modal.value = false;
    loading_reply_likes.value = false;
    last_reply_like.value = false;
  }


  function closeCommentLikesModal() {
    comment_likes.value = [];
    current_comment_id.value = null;
    show_comment_likes_modal.value = false;
    loading_comment_likes.value = false;
    last_comment_like.value = false;
  }

  function closePostLikesModal() {
    post_likes.value = [];
    current_post_id.value = null;
    show_post_likes_modal.value = false;
    loading_post_likes.value = false;
    last_post_like.value = false;
  }


  async function toggleFollowUser (user){

    try {

      if(user.following_loading){
        return
      }


      user.following_loading = true;

      let queryRoute = route('user.toggle_follow', {user: user.id});

      const response = await axios.post(queryRoute);
      console.log(response)
      user.following_loading = false;

      if (response.data.success && response.data.action != "") {

        user.following_status = response.data.action == "followed" ? true : false;
        toast.value = response.data.action
      } else {
        toast.value = 'Something went wrong'
      }
    } catch (error) {

      user.following_loading = false;
      if (error.response) {
        // Request made but the server responded with an error
        var status = error.response.status;
        if (status == 419) {
          document.location.reload()

        }

      } else if (error.request) {
        // Request made but no response is received from the server.
      } else {
        // Error occured while setting up the request
      }

      console.log('Something went wrong' + error)
      toast.value = 'Something went wrong'

      // Swal.fire({
      //   title: 'Ooops!',
      //   html: 'Something went wrong',
      //   icon: 'error',


      // });
    }
}

  function toggleSidebar (){
    sidebar_open.value = !sidebar_open.value;
  }

  function convertNumberToKOrMorB(number) {
    if (number < 1000) {
        return number;
    } else if (number < 1000000) {
        return (Math.round(number / 100) / 10).toFixed(1) + "K";
    } else {
        return (Math.round(number / 100000) / 10).toFixed(1) + "M";
    }
   }

  function convertbytesToMbOrKb(bytes) {
    if (bytes < 1024) {
      return `${bytes} B`
    }else if (bytes >= 1024 && bytes < 1048576) {
      return `${(bytes / 1024).toFixed(2)} KB`
    } else if (bytes >= 1048576) {
      return `${(bytes / 1048576).toFixed(2)} MB`
    }
  }

  function truncateStr(str, num) {
    return str.length > num ?  str.slice(0, num) + '...'  : str;
  }

  function replaceUnderscoreWithSpace(str){
    return str.replace(/_/g, ' ');
  };

  function toggleMainNavMenu(){
    show_nav_menu.value = !show_nav_menu.value
  };

  function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
  };

  function goBack(){
    window.history.back()
  };

  function changeIsAdminVal(val = false){
    is_admin.value = val
  };

  function isNumeric(str) {
    if (typeof str != "string") return false // we only process strings!
    return !isNaN(str) && // use type coercion to parse the _entirety_ of the string (`parseFloat` alone does not do this)...
      !isNaN(parseFloat(str)) // ...and ensure strings of whitespace fail
  };

  function addCommas(nStr) {
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
      x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
  };

  function setUser(payload) {
    if (payload.name) {
      userName.value = payload.name
    }
    if (payload.email) {
      userEmail.value = payload.email
    }
  }

  function fetchSampleClients() {
    axios
      .get(`data-sources/clients.json?v=3`)
      .then((result) => {
        clients.value = result?.data?.data
      })
      .catch((error) => {
        alert(error.message)
      })
  }

  function fetchSampleHistory() {
    axios
      .get(`data-sources/history.json`)
      .then((result) => {
        history.value = result?.data?.data
      })
      .catch((error) => {
        alert(error.message)
      })
  }

  return {
    userName,
    userEmail,
    userAvatar,
    isFieldFocusRegistered,
    clients,
    history,
    show_nav_menu,
    useSearchBtn,
    is_admin,
    notiDismissed,
    email_changed,
    sidebar_open,
    post_like_loading,
    comments_like_loading,
    replies_like_loading,
    show_post_likes_modal,
    toast,
    loading_post_likes,
    post_likes,
    last_post_like,

    show_comment_likes_modal,
    loading_comment_likes,
    comment_likes,
    last_comment_like,

    show_reply_likes_modal,
    loading_reply_likes,
    reply_likes,
    last_reply_like,
    show_post_more_options_modal,
    current_post,
    show_about_user_modal,
    current_comment,
    show_comment_more_options_modal,
    make_comment_form,
    show_comment_more_options_modal,
    current_comment,
    current_reply,
    current_comment_index,
    current_reply_index,
    show_reply_more_options_modal,
    current_follwers_user_id,
    show_user_followers_modal,
    user_followers,
    loading_user_followers,
    last_user_follower,
    current_post_index,
    show_noti_box,
    current_following_user_id,
    show_user_following_modal,
    loading_user_following,
    user_following,
    last_user_following,
    show_search_box,
    recent_search_loading,
    search_value,
    search_loading,
    search_results,
    recent_searches,
    delete_recent_search_loading,
    deleting_all_recent,
    show_form_box,
    community_details_global,
    show_community_more_options_modal,
    show_community_leader_form_modal,
    show_community_residents_modal,
    loading_community_residents,
    community_residents,
    last_community_resident,
    show_community_leaders_modal,
    loading_community_leaders,
    community_leaders,
    last_community_leader,
    show_manage_community_history_modal,
    show_upload_community_image_modal,
    closeCommunityImageModal,
    newCommunityGalleryImage,
    viewCommunityHistory,
    closeCommunityHistoryModal,
    manageCommunityHistory,
    closeCommunityLeadersModal,
    loadAllCommunityLeaders,
    closeCommunityResidentsModal,
    loadAllCommunityResidents,
    closeCommunityLeaderFormModal,
    applyAsCommunityLeader,
    closeCommunityMoreOptionsModal,
    showCommunityMoreOptions,
    hideSearchFormBox,
    showSearchFormBox,
    toggleSearchFormBox,
    deleteAllRecentSearches,
    clearAllRecentSearches,
    clearSingleRecentSearch,
    showSearchBox,
    hideSearchBox,
    toggleSearchBox,
    closeUserFollowingModal,
    loadUserFollowing,
    showNotiBox,
    hideNotiBox,
    toggleNotiBox,
    searchTextForHashTags,
    stripHtml,
    closeUserFollowerssModal,
    loadUserFollowers,
    convertNumberToKOrMorB,
    closeCommentReplyMoreOptionsModal,
    loadCommentReplyMoreOptions,
    makeReply,
    makeComment,
    deleteComment,
    deleteCommentReply,
    closeCommentMoreOptionsModal,
    loadCommentMoreOptions,
    formatDate,
    closeAboutAccountModal,
    aboutAccount,
    copyPostLink,
    sharePost,
    addPostToFavorites,
    toggleFollowUser,
    closePostMoreOptionsModal,
    loadPostMoreOptions,
    toggleFollowUser,
    closeReplyLikesModal,
    loadReplyLikes,
    closeCommentLikesModal,
    loadCommentLikes,
    closePostLikesModal,
    loadPostLikes,
    setUser,
    fetchSampleClients,
    fetchSampleHistory,
    replaceUnderscoreWithSpace,
    toggleMainNavMenu,
    getCookie,
    goBack,
    changeIsAdminVal,
    isNumeric,
    addCommas,
    truncateStr,
    convertbytesToMbOrKb,
    toggleSidebar
  }
})
