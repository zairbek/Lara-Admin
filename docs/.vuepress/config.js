module.exports = {
	base: '',
	title: 'Laravel Admin',
	description: '',
	host: 'localhost',
	port: 3001,
	dest: 'public',
	themeConfig: {
		nav: [
			{ text: 'Home', link: '/' },
			{ text: 'GitLab', link: 'https://gitlab.com/future-group/backend/packages/lara-admin' },
		],
		sidebar: [
			'/',
			'/structs',
			// '/usage',
			// '/hooks',
			// '/laravel-mix',
			// '/schema-org',
			// '/example-app',
		],
		displayAllHeaders: true,
		sidebarDepth: 2
	}
};