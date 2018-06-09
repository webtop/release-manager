module.exports = function(grunt) {
	
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		uglify: {
			options: {
				banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
			},
			build: {
				src: 'src/<%= pkg.name %>.js',
				dest: 'dist/public/js/<%= pkg.name %>.js'
			}
		},
		less: {
			paths: ['src/assets/css'],
			compress: true,
			ieCompat: true,
			files: {
				'dist/public/css/style.css': 'src/assets/css/style.less',
			}
		}
	});

	grunt.loadNpmTasks('grunt-config-uglify');
	grunt.loadNpmTasks('grunt-config-less');

	grunt.registerTask('default', ['uglify', 'less']);

};
