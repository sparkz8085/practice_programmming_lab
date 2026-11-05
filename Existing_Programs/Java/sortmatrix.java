import java.util.*;
public class sortmatrix
{
	public static void main(String args[])
	{
		Scanner sc=new Scanner(System.in);
		System.out.println("enter size of row: ");
		int row=sc.nextInt();
		System.out.println("enter size of column: ");
		int col=sc.nextInt();
		int ind=0;
		int arr[][]=new int[row][col];
		for (int i=0;i<row;i++)
		{
			for (int j=0;j<col;j++)
			{
				System.out.println("enter value "+ind+": ");
				arr[i][j]=sc.nextInt();
				ind++;
			}
		}
		for (int sort=0;sort<row*col-1;sort++)
		{
			for (int index=0;index<row*col-1-sort;index++)
			{
				int orow=index/col;
				int ocol=index%col;
				int nrow=(index+1)/col;
				int ncol=(index+1)%col;
				if (arr[orow][ocol]>arr[nrow][ncol])
				{
					int temp=arr[orow][ocol];
					arr[orow][ocol]=arr[nrow][ncol];
					arr[nrow][ncol]=temp;
				}
			}
		}
		System.out.println("entered values - ");
        	for (int i=0;i<row;i++) 
        	{
   	         	for (int j=0;j<col;j++) 
            	{
            		System.out.print(arr[i][j]+"\t");
            	}
            	System.out.println();
        }
        }
}	

