<template>
  <main class="home">
    <div id="lists">
      <table>
        <thead>
          <tr>
            <th>Index</th>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Size</th>
            <th>Progress</th>
            <th>Speed</th>
            <th>Active</th>
            <th>Error</th>
            <th>Success</th>
            <th>Abort</th>
            <th>customError</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(file, index) in files" :key="file.id">
              <td>{{index}}</td>
              <td>{{file.id}}</td>
              <td v-if="file.type.substr(0, 6) == 'image/' && file.blob">
                <img :src="file.blob" width="50" height="auto" />
              </td>
              <td v-else></td>
              <td>{{file.name}}</td>
              <td>{{file.size | formatSize}}</td>
              <td>{{file.progress}}</td>
              <td>{{file.speed | formatSize}}</td>
              <td>{{file.active}}</td>
              <td>{{file.error}}</td>
              <td>{{file.success}}</td>
              <td><button type="button" @click.prevent="abort(file)">Abort</button></td>
              <td><button type="button" @click.prevent="customError(file)">custom error</button></td>
              <td><button type="button" @click.prevent="remove(file)">x</button></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div id="options">
      <table>
        <tbody>
          <tr>
            <td>
              <file-upload
                :post-action="postAction"
                :put-action="putAction"
                :extensions="extensions"
                :accept="accept"
                :multiple="multiple"
                :directory="directory"
                :size="size"
                :thread="thread < 1 ? 1 : (thread > 5 ? 5 : thread)"
                :headers="headers"
                :data="data"
                :drop="drop"
                :dropDirectory="dropDirectory"
                v-model="files"
                @input-file="inputFile"
                ref="upload">
                Add upload files
              </file-upload>
            </td>
            <!-- <td>
              <button @click.prevent="addDirectory">Add upload directory</button>
              <br/>Only support chrome
            </td> -->
            <td>
              <button v-show="!$refs.upload || !$refs.upload.active" @click.prevent="$refs.upload.active = true" type="button">Start upload</button>
              <button v-show="$refs.upload && $refs.upload.active" @click.prevent="$refs.upload.active = false" type="button">Stop upload</button>
            </td>
            
            
          </tr>
          <tr>
            <td>
              Auto start: {{auto}}
            </td>
            <td>
              Active: {{$refs.upload ? $refs.upload.active : false}}
            </td>
            <td>
              Uploaded: {{$refs.upload ? $refs.upload.uploaded : true}}
            </td>
            <td>
              Drop active: {{$refs.upload ? $refs.upload.dropActive : false}}
            </td>
            <td>
              <label :for="name">Click</label>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-show="$refs.upload && $refs.upload.dropActive" class="drop-active">
      Drop ing
    </div>
  </main>
</template>


<script>
var FileUpload = require('vue-upload-component');
export default {
  components: {
    FileUpload:FileUpload
  },

  data() {
     return {
      csrf:'',
      files: [],
      accept: '.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel',
      size: 1024 * 1024 * 5,
      extensions: '.csv,xls,xlsx',
      multiple: false,
      directory: false,
      drop: true,
      dropDirectory: false,
      thread: 1,
      name: 'file',

      //postAction: './post.php',
      postAction: '/listasempaque',
      putAction: '',
      // putAction: '',

      headers: {
        "X-Csrf-Token": "",
      },

      data: {
        "_csrf_token": "",
      },


      auto: false,
    }
  },
  mounted(){
      
      this.csrf_token();

  },

  watch: {
    auto(auto) {
      if (auto && !this.$refs.upload.uploaded && !this.$refs.upload.active) {
        this.$refs.upload.active = true
      }
    }
  },

  methods: {
     csrf_token(){
        this.csrf = window.Laravel.csrfToken;
        this.headers= {
            "X-Csrf-Token" : this.csrf,
        };
        this.data._csrf_token = this.csrf;
     },
    // File Event
    inputFile(newFile, oldFile) {


      if (newFile && !oldFile) {
        // console.log('add', newFile)


        // 缩略图
        var URL = window.URL || window.webkitURL
        if (URL && URL.createObjectURL) {
          newFile = this.$refs.upload.update(newFile, {blob: URL.createObjectURL(newFile.file)})
        }

        // post filename
        newFile.data.name = newFile.name
      }

      if (newFile && oldFile) {
        // console.log('update', newFile, oldFile)

        if (newFile.active && !oldFile.active) {
          // this.beforeSend(newFile)

          // min size
        //   if (newFile.size >= 0 && newFile.size < 100 * 1024) {
        //     newFile = this.$refs.upload.update(newFile, {error: 'size'})
        //   }
        }

        if (newFile.progress != oldFile.progress) {
          // this.progress(newFile)
          // console.log('progress', newFile.progress)
        }

        if (newFile.error && !oldFile.error) {
          // this.error(newFile)
           console.log('error', newFile.error, newFile.response)
        }

        if (newFile.success && !oldFile.success) {
          // this.success(newFile)
           console.log('success', newFile.response)
        }
      }


      if (!newFile && oldFile) {
        // this.remove(oldFile)
        // console.log('remove', oldFile)
      }


      // 自动开始
      if (this.auto && !this.$refs.upload.uploaded && !this.$refs.upload.active) {
        this.$refs.upload.active = true
      }
    },

    abort(file) {
      this.$refs.upload.update(file, {active: false})
      // or
      // this.$refs.upload.update(file, {error: 'abort'})
    },

    customError(file) {
      this.$refs.upload.update(file, {error: 'custom'})
    },
    remove(file) {
      this.$refs.upload.remove(file)
    },

  },
}



</script>
<style>
.home {
  position: relative;
}

.file-uploads {
  font-size: 18px;
  padding: .6em;
  font-weight: bold;
  border: 1px solid #888;
  background: #f3f3f3
}


.drop-active {
  top: 0;
  bottom: 0;
  right: 0;
  left: 0;
  position: absolute;
  opacity: .4;
  background: #000;
}
button {
  padding: .6em;
}

table {
  margin-bottom: 2em
}
table th,table td {
  padding: .4em;
  border: 1px solid #ddd
}

</style>
