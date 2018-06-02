from setuptools import setup, find_packages

setup(name='calculadoraAlimentos',
      version='1.1.0',
      description='calculadora de alimentos y beneficio para la web Las Gemelas al Jerez',
      url='https://www.lasgemelasaljerez.com',
      author='NekuNeko',
      author_email='flyingcircus@example.com',
      license='GNU',
      packages=find_packages(),
      install_requires=[
          'measurement',
          'XlsxWriter',
          'mysql-connector',
          'protobuf',
          'pandas',
          'numpy',
          'xlrd',
          'jinja2',
          'pdfkit',
      ],
      zip_safe=False)


print("\n")
print("Instalación terminada")
print("Por favor, instala manualmente los paquetes: wkhtmltopdf y xvfb")
print("sudo apt install wkhtmltopdf xvfb")

# Fuente: https://gist.github.com/tzi/251bece8f7763138111c
#print("sudo apt install python3-cffi libcairo2-dev libpango1.0-dev")
#print("sudo apt-get install libxml2-dev libxslt-dev libffi-dev libcairo2-dev libpango1.0-dev python-dev python-pip")
#print("sudo pip install WeasyPrint")