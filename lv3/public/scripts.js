fetch('weather.csv')
    .then(res => {
        console.log('Fetching CSV file...');
        return res.text();  // Fetch the CSV file as text
    })
    .then(csv => {
        console.log('CSV file fetched successfully:');
        console.log(csv);  // Log the raw CSV content

        // Parse the CSV using PapaParse
        const rezultat = Papa.parse(csv, {
            header: true,  // Use the first row as headers
            skipEmptyLines: true  // Skip empty lines
        });

        // Log the parsed data to check if it's being parsed correctly
        console.log('Parsed CSV data:', rezultat.data);

        if (!rezultat.data || rezultat.data.length === 0) {
            console.error('No data available after parsing the CSV!');
            return;
        }

        // Check if the CSV headers are correct
        console.log('CSV Headers:', rezultat.meta.fields);

        // Process the data after parsing
        const vrijeme = rezultat.data.map(day => ({
            ID: day.ID,
            temperatura: Number(day.Temperature),  // Temperature renamed to temperaatura
            sezona: day.Season,  // Season renamed to sezona
            lokacija: day.Location,  // Location renamed to lokacija
            vrsta_vremena: day["Weather Type"],  // Weather Type renamed to vrsta_vremena
        }));

        // Log the mapped data to see if it's correct
        console.log('Mapped data:', vrijeme);

        // Get the first 20 records
        const prvih20 = vrijeme.slice(0, 20);

        // Log the first 20 records to ensure the data is correctly sliced
        console.log('First 20 records:', prvih20);

        // Call the function to display the data in the table
        prikaziTablicu(prvih20);
    })
    .catch(err => {
        console.error('Error fetching the CSV:', err);
    });


    function prikaziTablicu(vrijeme) {
        const tbody = document.querySelector('#vrijeme-tablica tbody');
        tbody.innerHTML = ''; // Clear the table if there's any data
        for (const day of vrijeme) {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${day.ID}</td>
                <td>${day.temperatura}</td>
                <td>${day.sezona}</td>
                <td>${day.lokacija}</td>
                <td>${day.vrsta_vremena}</td>
            `;
            tbody.appendChild(row);
        }
    }
    


