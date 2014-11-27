module.exports = function(grunt) {
  grunt.initConfig({
    less: {
      options : {
        'compress' : true
      },
      dist: {
        files: {
          'public/css/min.css': 'public/less/style.less'
        }
      }
    },

    watch: {
      files: ['public/less/*'],
      tasks: ['less'],
    }
  });

  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.registerTask('default', ['less']);
}